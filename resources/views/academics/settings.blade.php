@extends('layouts.app')

@section('content')
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-tools"></i> @lang('Academic Settings')
                    </h1>

                    @include('session-messages')
                    <div class="card-header bg-transparent  border shadow-sm">
                        <ul class="nav nav-tabs card-header-tabs"  id="Tabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#periodos" role="tab" aria-current="true"><i class="bi bi-diagram-3"></i> 1- @lang('Periodos')</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#semestre" role="tab" aria-current="false"><i class="bi bi-journal-text"></i> 2-  @lang('Agrupamiento Mensual')</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nivel" role="tab" aria-current="false"><i class="bi bi-journal-medical"></i> 3- @lang('Niveles')</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#asignaturas" role="tab" aria-current="false"><i class="bi bi-journal-medical"></i> 4- @lang('Asignaturas')</button>
                            </li> 
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#docentes" role="tab" aria-current="false"><i class="bi bi-journal-medical"></i> 5- @lang('Asignación Docentes')</button>
                            </li> 

                        </ul>
                    </div>
                    <div class="card-body text-dark">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="periodos" role="tabpanel">
                                <div class="row">           
                                    <div class="col-md-4 offset-md-2 mb-4">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Create Session')</h6>
                                            <p class="text-danger">
                                                <small><i class="bi bi-exclamation-diamond-fill me-2"></i> Crear una sesión por periodo academico. La última sesion creada será considerada como el último periodo académico.</small>
                                            </p>
                                            <form action="{{route('school.session.store')}}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-sm" placeholder="ej: Ciclo 2022" aria-label="Current Session" name="session_name" required>
                                                </div>
                                                <button class="btn btn-sm btn-success" type="submit"><i class="bi bi-check2"></i> @lang('Create')</button>
                                            </form>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-4 mb-4">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Browse by Session')</h6>
                                            <p class="text-danger">
                                                <small><i class="bi bi-exclamation-diamond-fill me-2"></i> Solo use esta opción cuando quiera ver datos de un periodo anterior.</small>
                                            </p>
                                            <form action="{{route('school.session.browse')}}" method="POST">
                                                @csrf
                                            <div class="mb-3">
                                                <p class="mt-2">@lang("Select 'Session' to browse by"):</p>
                                                <select class="form-select form-select-sm" aria-label=".form-select-sm" name="session_id" required>
                                                    @isset($school_sessions)
                                                        @foreach ($school_sessions as $school_session)
                                                            <option value="{{$school_session->id}}">{{$school_session->session_name}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                            <button class="btn btn-sm btn-success" type="submit"><i class="bi bi-check2"></i> @lang('Set')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="semestre" role="tabpanel">
                                <div class="row">    
                                    @if ($latest_school_session_id == $current_school_session_id)
                                    <div class="col-md-8 mb-8">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Create Semester for Current Session')</h6>
                                                @csrf
                                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>@lang('Semester name')</label>
                                                    <input type="text" class="form-control form-control-sm" placeholder="ej: Primer Cuatrimestre" aria-label="Semester name" id="semester_name" name="semester_name" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>@lang('Starts')</label>
                                                    <input type="date" class="form-control form-control-sm"  placeholder="Starts" id="start_date" name="start_date" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>@lang('Ends')</label>
                                                    <input type="date" class="form-control form-control-sm" placeholder="Ends" id="end_date" name="end_date" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button id="btnGrabaSemestre" type="button" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Attendance Type')</h6>
                                            <p class="text-danger">
                                                <small><i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('No cambie el tipo de asistencia en medio de un semestre').</small>
                                            </p>
                                            <form action="{{route('school.attendance.type.update')}}" method="POST">
                                                @csrf
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="attendance_type" id="attendance_type_section" {{($academic_setting->attendance_type == 'section')?'checked="checked"':null}} value="section">
                                                    <label class="form-check-label" for="attendance_type_section">
                                                        @lang('Attendance by Section')
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="attendance_type" id="attendance_type_course" {{($academic_setting->attendance_type == 'course')?'checked="checked"':null}} value="course">
                                                    <label class="form-check-label" for="attendance_type_course">
                                                        @lang('Attendance by Course')
                                                    </label>
                                                </div>
                                                <button type="submit" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="50%"> @lang('Name')</th>
                                                    <th scope="col" width="20%"> @lang('Start')</th>
                                                    <th scope="col" width="20%"> @lang('End')</th>
                                                    <th scope="col" width="10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodySemestre">
                                                @isset($semesters)
                                                    @foreach ($semesters as $semester)
                                                    <tr>
                                                        <td>{{$semester->semester_name}}</td>
                                                        <td>{{$semester->start_date->format('d/m/Y')}}</td>
                                                        <td>{{$semester->end_date->format('d/m/Y')}}</td>
                                                        <td>
                                                            @can('edit classes')
                                                            <button onClick="javascript:Eliminar({{$semester->id}});" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                            @endcan   
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endisset                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nivel" role="tabpanel">
                                <div class="row"> 
                                @if ($latest_school_session_id == $current_school_session_id)
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Create Class')</h6>
                                                @csrf
                                                <input type="hidden" id="session_id" name="session_id" value="{{$current_school_session_id}}">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-sm" id="class_name" name="class_name" placeholder="ej: Primer Año" aria-label="Class name" required>
                                                </div>
                                                <button id="btnGrabaNivel" class="btn btn-sm btn-success" type="button"><i class="bi bi-check2"></i> @lang('Create')</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 border bg-light shadow-sm card">
                                        <h6>@lang('Create Section')</h6>
                                                @csrf
                                                <input type="hidden" id="session_id" name="session_id" value="{{$current_school_session_id}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm" id="class_id" name="class_id" required>
                                                            @isset($school_classes)
                                                                @foreach ($school_classes as $school_class)
                                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                </div>                                                
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-8">
                                                        <input class="form-control form-control-sm" id="section_name" name="section_name" type="text" placeholder="ej: Primera División" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control form-control-sm" id="room_no" name="room_no" type="text" placeholder="Aula No.">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" id="btnGrabaDivision" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="90%"> @lang('Section')</th>
                                                    <th scope="col" width="10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodyNivel">
                                                @isset($school_classes)
                                                    @foreach ($school_classes as $school_class)
                                                    <tr>
                                                        <td>{{$school_class->class_name}}</td>
                                                        <td>
                                                            @can('edit classes')
                                                            <button onClick="javascript:Eliminar({{$school_class->id}});" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                            @endcan   
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endisset                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">@lang('Class')</th>
                                                    <th scope="col">@lang('Section')</th>
                                                    <th scope="col">@lang('Aula')</th>                                                      
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodySection">
                                                @isset($school_sections)
                                                    @foreach ($school_sections as $school_section)
                                                    <tr>
                                                        <td>{{$school_section->schoolClass->class_name}}</td>
                                                        <td>{{$school_section->section_name}}</td>
                                                        <td>{{$school_section->room_no}}</td>                                                        
                                                        <td>
                                                            @can('edit classes')
                                                            <button onClick="javascript:Eliminar({{$school_section->id}});" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                            @endcan   
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endisset   
                                            </tbody>
                                        </table>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="asignaturas" role="tabpanel">
                                 @if ($latest_school_session_id == $current_school_session_id)
                                 <div class="row">
                                    <div class="col-md-8  offset-md-2">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Create Course')</h6>
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                                    <div class="col-md-4">
                                                        <label>@lang('Assign to class')</label>
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm" id="asig_class_id" name="asig_class_id" required>
                                                            @isset($school_classes)
                                                                @foreach ($school_classes as $school_class)
                                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>                                                    
                                                    <div class="col-md-4">
                                                        <label>@lang('Name')</label>
                                                        <input type="text" class="form-control form-control-sm" id="asig_course_name" name="asig_course_name" placeholder="ej: Matemática" aria-label="Course name" required>
                                                    </div>
                                                    <div class="col-md-4" style="display: none;">
                                                        <p>@lang('Assign to semester')<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm" id="asig_semester_id" name="asig_semester_id" required>
                                                            @isset($semesters)
                                                                @foreach ($semesters as $semester)
                                                                <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>@lang('Course Type')</label>
                                                        <select class="form-select form-select-sm" id="asig_course_type" name="asig_course_type" aria-label=".form-select-sm" required>
                                                            <option value="General">@lang('General')</option>
                                                            <option value="Opcional">@lang('Optional')</option>
                                                        </select>
                                                    </div>                                                    
                                                </div>
                                                <div class="row" style="margin-top:10px">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-sm btn-success" id="btnGrabaAsignatura" type="button"><i class="bi bi-check2"></i> @lang('Create')</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div> 

                                    <div class="col-md-8 offset-md-2">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th width="30%" scope="col">@lang('Class')</th>
                                                    <th width="30%" scope="col">@lang('Name')</th>
                                                    <th width="30%" scope="col">@lang('Course Type')</th>                                                      
                                                    <th width="10%" scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodyAsignatura">
                                                @isset($courses)
                                                    @foreach ($courses as $course)
                                                    <tr>
                                                        <td>{{$course->class->first()->class_name}}</td>
                                                        <td>{{$course->course_name}}</td>
                                                        <td>{{$course->course_type}}</td>                                                        
                                                        <td>
                                                            @can('edit courses')
                                                            <button onClick="javascript:Eliminar({{$course->id}});" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                            @endcan   
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endisset   
                                            </tbody>
                                        </table>
                                    </div> 

                                 </div>
                                 @endif

                            </div>
                            <div class="tab-pane fade" id="docentes" role="tabpanel">
                                <div class="row">
                                    @if ($latest_school_session_id == $current_school_session_id)
                                    <div class="col-md-10 mb-10">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Assign Teacher')</h6>
                                                @csrf
                                                <p class="text-danger">
                                                    <small><i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Cree los docentes desde el menú lateral antes de poder seleccionarlo').</small>
                                                </p>
                                                <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>@lang('Teacher')</label>
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm" id="docente_teacher_id" name="docente_teacher_id" required>
                                                            @isset($teachers)
                                                                @foreach ($teachers as $teacher)
                                                                <option value="{{$teacher->id}}">{{$teacher->first_name}} {{$teacher->last_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" style="display:none">
                                                        <label>@lang('Assign to semester')</label>
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm" name="semester_id" required>
                                                            @isset($semesters)
                                                                @foreach ($semesters as $semester)
                                                                <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" >
                                                        <label>@lang('Assign to class')</label>
                                                        <select onchange="getSectionsAndCourses(this);" class="form-select form-select-sm" aria-label=".form-select-sm" id="docente_class_id" name="docente_class_id" required>
                                                            @isset($school_classes)
                                                                <option selected disabled>@lang('Please select one')</option>
                                                                @foreach ($school_classes as $school_class)
                                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" >
                                                        <label>@lang('Assign to section')</label>
                                                        <select class="form-select form-select-sm" id="section-select" aria-label=".form-select-sm" name="docente_section_id" required>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" >
                                                        <label>@lang('Assign to course')</label>
                                                        <select  class="form-select form-select-sm" id="course-select" aria-label=".form-select-sm" name="docente_course_id" required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button id="btnGrabaDocente" type="button" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <div class="p-3 border bg-light shadow-sm card">
                                            <h6>@lang('Allow Final Marks Submission')</h6>
                                            <form action="{{route('school.final.marks.submission.status.update')}}" method="POST">
                                                @csrf
                                                <p class="text-primary">
                                                    <small><i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Disallow at the start of a Semester').</small>
                                                </p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="marks_submission_status" id="marks_submission_status_check" {{($academic_setting->marks_submission_status == 'on')?'checked="checked"':null}}>
                                                    <label class="form-check-label" for="marks_submission_status_check">{{($academic_setting->marks_submission_status == 'on')?'Permitir':'No Permitir'}}</label>
                                                </div>
                                                <button type="submit" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                    <div class="col-md-10">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th width="20%" scope="col">@lang('Teacher')</th>
                                                    <th width="20%" scope="col">@lang('Class')</th>
                                                    <th width="20%">@lang('Section')</th>
                                                    <th width="30%" scope="col">@lang('Course Name')</th>                                                      
                                                    <th width="10%" scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodyDocentes">
                                                @isset($assignedTeachers)
                                                    @foreach ($assignedTeachers as $assignedTeacher)
                                                    <tr>
                                                        <td>{{$assignedTeacher->teacher->first_name}} {{$assignedTeacher->teacher->last_name}}</td>
                                                        <td>{{$assignedTeacher->schoolClass->class_name}} </td>
                                                        <td>{{$assignedTeacher->section->section_name}}</td>  
                                                        <td>{{$assignedTeacher->course->course_name}}</td>                                                   
                                                        <td>
                                                            @can('edit courses')
                                                            <button onClick="javascript:Eliminar(this);" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                            @endcan   
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endisset   
                                            </tbody>
                                        </table>
                                    </div> 

                            </div>

                        </div>
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
            var courseSelect = document.getElementById('course-select');
            courseSelect.options.length = 0;
            data.courses.unshift({'id': 0,'course_name': 'Seleccione un opción'})
            data.courses.forEach(function(course, key) {
                courseSelect[key] = new Option(course.course_name, course.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    $('#btnGrabaDocente').on('click',function(){
        let url = "{{route('school.teacher.assign')}}";
        docente_teacher_id  = $('#docente_teacher_id').val();
        docente_class_id    = $('#docente_class_id').val();
        docente_section_id  = $('#section-select').val();
        docente_course_id   = $('#course-select').val();
        teacher_text = $("#docente_teacher_id option:selected").text(); 
        class_text = $("#docente_class_id option:selected").text(); 
        section_text = $("#section-select option:selected").text();
        course_text = $("#course-select option:selected").text();           

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?teacher_id='+docente_teacher_id+'&class_id='+docente_class_id+'&section_id='+docente_section_id+'&course_id='+docente_course_id,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $('#asig_course_name').val('');
                    $("#bodyDocentes").append('<tr><td>'+teacher_text+'</td><td>'+class_text+'</td><td>'+section_text+'<td>'+course_text+'</td></td><td><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    $('#btnGrabaAsignatura').on('click',function(){
        let url = "{{route('school.course.create')}}";
        asig_course_name    = $('#asig_course_name').val();
        asig_course_type    = $('#asig_course_type').val();
        asig_semester_id    = $('#asig_semester_id').val();
        asig_class_id       = $('#asig_class_id').val();
        class_text = $("#asig_class_id option:selected").text();   
        course_type_text = $("#asig_course_type option:selected").text(); 

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?course_name='+asig_course_name+'&course_type='+asig_course_type+'&semester_id='+asig_semester_id+'&class_id='+asig_class_id,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $('#asig_course_name').val('');
                    $("#bodyAsignatura").append('<tr><td>'+class_text+'</td><td>'+asig_course_name+'</td><td>'+course_type_text+'</td><td><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                }
            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    $('#btnGrabaSemestre').on('click',function(){
        let url = "{{route('school.semester.create')}}";
        semester_name = $('#semester_name').val();
        start_date = $('#start_date').val();
        end_date = $('#end_date').val();

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?semester_name='+semester_name+'&start_date='+start_date+'&end_date='+end_date,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $("#bodySemestre").append('<tr><td>'+semester_name+'</td><td>'+start_date+'</td><td>'+end_date+'</td><td><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                    $('#semester_name').val('');
                    $('#start_date').val('');
                    $('#end_date').val('');                    
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    $('#btnGrabaNivel').on('click',function(){
        let url = "{{route('school.class.create')}}";
        class_name = $('#class_name').val();
        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?class_name='+class_name,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                $("#bodyNivel").append('<tr><td>'+class_name+'</td><td><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    $('#btnGrabaDivision').on('click',function(){
        let url = "{{route('school.section.create')}}";
        section_name = $('#section_name').val();
        room_no = $('#room_no').val();
        class_id = $('#class_id').val();
        class_text = $("#class_id option:selected").text();

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?class_id='+class_id+'&section_name='+section_name+'&room_no='+room_no,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    $('#section_name').val('');
                    $('#room_no').val('');
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $("#bodySection").append('<tr><td>'+class_text+'</td><td>'+section_name+'</td><td>'+room_no+'</td><td><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    function Eliminar(me){
        Swal.fire("Oops!... opción no disponible para este usuario DEMO", "", "error");
    }

</script>
@endsection
