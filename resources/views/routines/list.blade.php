@extends('layouts.app')


<div class="modal fade" id="horarioModal" tabindex="-1" role="dialog" aria-labelledby="horarioModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">@lang('Edit') @lang('Routine') </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card p-3 border bg-light shadow-sm">
                    <form action="{{route('section.routine.update')}}" method="POST">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="mt-2">
                            <p>@lang('Week Day')<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                            <select class="form-select" id="weekday" name="weekday" required>
                                <option value="1">@lang('Monday')</option>
                                <option value="2">@lang('Tuesday')</option>
                                <option value="3">@lang('Wednesday')</option>
                                <option value="4">@lang('Thursday')</option>
                                <option value="5">@lang('Friday')</option>
                                <option value="6">@lang('Saturday')</option>
                                <option value="7">@lang('Sunday')</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="inputStarts" class="form-label">@lang('Starts')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                            <input type="text" class="form-control" id="inputStarts" name="start" placeholder="09:00am" required>
                        </div>
                        <div class="mt-2">
                            <label for="inputEnds" class="form-label">@lang('Ends')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                            <input type="text" class="form-control" id="inputEnds" name="end" placeholder="09:50am" required>
                        </div>
                        <button type="submit" class="mt-3 btn btn-sm btn-outline-primary"><i class="bi bi-check2"></i> @lang('Save')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('content')
<style type="text/css">
    table {
        display: table;
        overflow-x: auto;
    }
</style>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Routine List')  </h1>
                    @include('session-messages')
                    <div class="mb-4 mt-4">
                        <form class="row" action="{{route('routine.list.show')}}" method="GET">
                            <div class="col-md-4 mt-4">
                                <select onchange="getSections(this);" class="form-select" aria-label="Class" name="class_id" required>
                                    <option selected>@lang('Please select one')</option>
                                    @isset($school_classes)
                                        @foreach ($school_classes as $school_class)
                                            <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-4 mt-4">
                                <select onchange="buscar(this);" class="form-select" id="section-select" aria-label="Section" name="section_id" required>
                                    <option value="{{request()->query('section_id')}}">{{request()->query('section_name')}}</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" style="display:none" id="btnBuscar" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i> @lang('Load List')</button>
                            </div>
                        </form>
                        @foreach ($routineList as $routine)
                            @if ($loop->first)
                                <p class="mt-3"><h4><b>@lang('Section'):</b> {{$routine->schoolClass->class_name}} {{$routine->section->section_name}}</h4></p>
                                @break
                            @endif
                        @endforeach
                        <div class="col-md-8 offset-md-2">
                        <div class="card bg-white border shadow-sm p-3 mt-4">
                            @can ('create routines')
                            <div class="col-md-4">
                                <a href="{{route('section.routine.create')}}" style="width:100%" id="btnAgregar" type="button" class="btn btn-sm btn-primary">@lang('Add')</a>
                            </div> 
                            @endcan 
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('#')</th>
                                        <th scope="col">@lang('Course')</th>
                                        <th scope="col">@lang('Weekday')</th>
                                        <th scope="col">@lang('Start')</th>
                                        <th scope="col">@lang('End')</th>
                                        @can('edit routine')
                                        <th scope="col">@lang('Actions')</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($routineList as $routine)
                                    <tr>
                                        <td id="id_{{$routine->id}}">{{$routine->id}}</td>
                                        <th scope="row">{{$routine->course->course_name}}</th>
                                        <td id="dia_{{$routine->id}}">{{$routine->dia->name}}</td>
                                        <td id="start_{{$routine->id}}">{{$routine->start}}</td>
                                        <td id="end_{{$routine->id}}">{{$routine->end}}</td>
                                        <td>
                                        @can('edit routine')
                                            <div class="btn-group" role="group">
                                                <button type="button" onClick="javascript:EditarHorario(this);" data-link="{{route('section.routine.show',$routine->id)}}" data-id="{{$routine->id}}" class="btn btn-sm btn-primary"><i class="bi bi-trash2"></i> @lang('Edit')</button>

                                                <button type="button" onClick="javascript:EliminarHorario(this);" data-link="{{route('routine.destroy',$routine->id)}}" data-id="{{$routine->id}}" class="btn btn-sm btn-danger"><i class="bi bi-trash2"></i> @lang('Delete')</button>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<script>
    function EditarHorario(me) {
        let link = $(me).data('link');
        id =  $('#id_'+$(me).data('id')).text();
        dia =  $('#dia_'+$(me).data('id')).text();
        start = $('#start_'+$(me).data('id')).text();
        end = $('#end_'+$(me).data('id')).text();

        $('#id').val(id);
        $("#weekday").find("option:contains('"+dia+"')").attr('selected','selected');
       // $('#weekday').val();
        $('#inputStarts').val(start);
        $('#inputEnds').val(end);
        $("#horarioModal").modal('show');
    }; 

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
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    function EliminarHorario(me){
        let link  = $(me).data('link');
        let id  = $(me).data('id');
        
        Swal.fire({
          title: "Eliminar Horario",
          text: "¿Está seguro que desea eliminar el horario?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
        /*  cancelButtonColor: '#d33',*/
          confirmButtonText: "Si, Eliminar",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                method: 'POST',
                data:{id:id},
                type: 'json',
                url: link,
                headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
            }).done(function(response) {
               // Swal.fire("Felicitaciones!", response, "success");
               window.location.reload();
            }).fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always(()=>$('body').unblock());;

          }
        })
    }
    function buscar(){
        $('#btnBuscar').click();
    }       
</script>
@endsection
