@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Student List')  </h1>
                    @include('session-messages')
                    <div class="mb-4 mt-4">
                        <form class="row" action="{{route('student.legajo.show')}}" method="GET">
                            <div class="col-md-4 mb-4">
                                <select onchange="getSections(this);" class="form-select" aria-label="Class" name="class_id" required>
                                    <option selected>@lang('Please select one')</option>
                                    @isset($school_classes)
                                        @foreach ($school_classes as $school_class)
                                            <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <select onchange="buscar(this);" class="form-select" id="section-select" aria-label="Section" name="section_id" required>
                                    <option value="{{request()->query('section_id')}}">{{request()->query('section_name')}}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button style="display:none"  id="btnBuscar" type="submit" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i> @lang('Load List')</button>
                            </div>
                        </form>
                        <div class="card bg-white border shadow-sm p-3 mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%" scope="col">@lang('Photo')</th>
                                        <th width="10%" scope="col">@lang('Legajo')</th>
                                        <th width="20%" scope="col">@lang('Name')</th>
                                        <th width="20%" scope="col">@lang('Class')</th>
                                        <th width="10%" scope="col">@lang('Unattendances')</th>
                                        <th width="10%" scope="col">@lang('Late')</th>
                                        <th width="30%" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentList as $student)
                                    <tr>
                                        <td>
                                            @if (isset($student->student->photo))
                                                <img src="{{asset('/storage'.$student->student->photo)}}" class="rounded" alt="Profile picture" height="30" width="30">
                                            @else
                                               <img src="{{asset('/storage/photos/profile.png')}}" class="rounded" alt="Profile picture" height="30" width="30">
                                            @endif
                                        </td>
                                        <th scope="row">{{$student->student->promotion->id_card_number}}</th>
                                        <td>{{$student->student->first_name}} {{$student->student->last_name}}</td>
                                        <td>{{$student->student->promotion->schoolClass->class_name}} {{$student->student->promotion->section->section_name}}</td>
                                        <td >{{ $student->student->attendances->where('status','off')->count()}}</td>
                                        <td >{{ $student->student->attendances->where('status','tarde')->count()}}</td>
                                        <td >
                                            <div class="btn-group" role="group">
                                                <a href="{{url('students/view/profile/'.$student->student->id)}}" role="button" class="btn btn-sm btn-primary">@lang('Legajo')</a>
                                                @can('view attendances')
                                                <a href="{{route('student.attendance.show', ['id' => $student->student->id])}}" role="button" class="btn btn-sm btn-success"> @lang('Attendance')</a>
                                                @endcan 
                                                <a href="{{route('student.boletin.show', ['id' => $student->student->id])}}" role="button" class="btn btn-sm btn-default" style="background-color: indigo;">@lang('Grades')</a>
                                                <a style="background-color: brown;" href="#" role="button" class="btn btn-sm btn-success btnDocumentos">@lang('Documentación')</a>
                                                @can('create notices')
                                                <a href="{{route('notice.student.create', ['student_id' => $student->student->id])}}" role="button" class="btn btn-sm btn-warning">@lang('Notices')</a> 
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<div class="modal fade" id="importarModal" role="dialog">
    <div class="modal-dialog modal-right modal-notify modal-info" role="document"  style="min-width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
              <p class="heading lead">@lang('Import') @lang('Students')<span id="spTitulo"></span></p> 
            </div>
            <div class="modal-body" id="bodyImportar">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-3">
                        <a href="{{asset('modelos/alumnos.xlsx')}}" style="text-align: center;display: block;" type="button" class="btn btn-round btn-primary"></i> @lang('Download Model')</a>
                    </div> 
                </div>

                <div class="row">
                  <div class="col-md-6">
                        <select onchange="getSections(this);" class="form-select" aria-label="Class" id="class_id_1" name="class_id_1" required>
                            <option selected>@lang('Please select one')</option>
                            @isset($school_classes)
                                @foreach ($school_classes as $school_class)
                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                @endforeach
                            @endisset
                        </select>
                  </div>
                    <div class="col-md-6">
                        <select class="form-select" id="section_id_1" name="section_id_1" required>
                        </select>
                    </div>                  
                </div>
                <div class="row">  
                  <div class="col-md-10 offset-md-1" style="margin-top: 20px;margin-bottom: 20px;">
                    <input class="form-control" type="file" name="archivoxls" id="archivoxls">
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a style="width: 100%;text-align: center;display: block;" type="button" id="btnCierraImportar" class="btn btn-default btn-round" data-dismiss="modal">@lang('Cancel')</a>
                    </div>
                    <div class="col-md-6">   
                          <a style="width: 100%;text-align: center;display: block;" type="button" onclick="importar()" class="btn btn-round btn-success "></i> @lang('Import')</a>
                    </div>
                </div>                  
            </div> 
        </div>
    </div>
</div>


<script>
function importar(){
        let url = "{{route('students.importar')}}";
        class_id    = $('#class_id_1').val();
        section_id  = $('#section_id_1').val();
        var file = $('#archivoxls')[0].files[0];

        var formData = new FormData();
        formData.append('file',file);
        formData.append('class_id',class_id);
        formData.append('section_id',section_id);

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: url,
            data:formData,
            contentType: false,
            processData: false,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                //response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                     $('#importarModal').modal('hide');
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    })
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
}

    function getSections(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 
        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {

            var sectionSelect = document.getElementById('section-select');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Seleccione una opción'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });

            var sectionSelect1 = document.getElementById('section_id_1');
            sectionSelect1.options.length = 0;
            data.sections.forEach(function(section, key) {
                sectionSelect1[key] = new Option(section.section_name, section.id);
            });

        })
        .catch(function(error) {
            console.log(error);
        });
    }

    function buscar(){
        $('#btnBuscar').click();
    }
    
$('document').ready(function(){
    $('#btnImportar').click(function(){
        $('#importarModal').modal('show');
    })

    $('#btnCierraImportar').click(function(){
        $('#importarModal').modal('hide');
    })

    $('.btnDocumentos').click(function(){
        Swal.fire("Oops!... opción no disponible para este usuario DEMO", "", "error");
    })

});

</script>

@endsection





