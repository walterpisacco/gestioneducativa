@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-file-text"></i> @lang('Exams')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Exam')</li>
                        </ol>
                    </nav>
                    <div class="mb-4 mt-4">
                        <form action="{{route('exam.list.show')}}" method="GET">
                            <div class="row">
                                <div class="col-3">
                                    <select class="form-select" aria-label="Status" name="semester_id">
                                        @isset($semesters)
                                            @foreach ($semesters as $semester)
                                                <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>                                
                                <div class="col-3">
                                    <select onchange="getSectionsAndCourses(this);" class="form-select" aria-label="Class" name="class_id">
                                        <option value=""> @lang('Please select one')</option>
                                        @isset($classes)
                                            @foreach ($classes as $school_class)
                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select onchange="buscar(this);" class="form-select form-select-sm" id="section-select" aria-label=".form-select-sm" name="section_id" required>
                                    </select>
                                </div>                                  
                                <div class="col">
                                    <button style="display:none" id="btnBuscar" type="submit" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i> @lang('Load List')</button>
                                </div>
                            </div>
                        </form>
                        <div class="card bg-white mt-4 p-3 border shadow-sm">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('#')</th>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Course')</th>
                                        <th scope="col">@lang('Marks Distribution Note')</th>
                                        <th scope="col">@lang('Total Marks')</th>
                                        <th scope="col">@lang('Pass Marks')</th>
                                        <th scope="col">@lang('Date')</th>
                                        @can('edit exams rule')
                                        <th scope="col">@lang('Actions')</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        @foreach ($teacher_courses as $teacher_course)
                                            @if ($exam->course->id == $teacher_course->course_id and $exam->section_id == $teacher_course->section_id)
                                            <tr>
                                                <td id="id_{{$exam->id}}">{{$exam->id}}</td>
                                                <td>{{$exam->exam_name}}</td>
                                                <td>{{$exam->course->course_name}}</td>
                                                <td>{{$exam->rule->marks_distribution_note ?? null}}</td>
                                                <td>{{$exam->rule->total_marks ?? null}}</td>
                                                <td>{{$exam->rule->pass_marks ?? null}}</td>
                                                <td>{{$exam->start_date->format('d/m/Y')}}</td>
                                                 @can('edit exams rule')
                                                <td>
                                                    <div class="btn-group" role="group">
                                                          <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" role="button" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> @lang('View Rule')</a>
                                                    @can('delete exams')
                                                    <button type="button" onClick="javascript:EliminarExamen(this);" data-link="{{route('exam.destroy',$exam->id)}}" data-id="{{$exam->id}}" class="btn btn-sm btn-danger"><i class="bi bi-trash2"></i> @lang('Delete') @lang('Exam')</button>
                                                    @endcan
                                                </div>

                                                    </div>
                                                </td>
                                                @endcan
                                            </tr>
                                            @else
                                                @continue
                                            @endif
                                        @endforeach
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

<script>

    function getSectionsAndCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('section-select');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Seleccione un opción'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    function EliminarExamen(me){
        let link  = $(me).data('link');
        let id  = $(me).data('id');

        Swal.fire({
          title: "Eliminar Examen",
          text: "¿Está seguro que desea eliminar el examen?",
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
            });

          }
        })
    }   

    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 
        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('inputAssignToSection');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Seleccione un opción'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    } 

        function buscar(){
            $('#btnBuscar').click();
        }       
</script>

@endsection
