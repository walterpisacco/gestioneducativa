@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-file-plus"></i> @lang('Create Exam')</h1>
                    @include('session-messages')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-3 border bg-light shadow-sm">
                                <form action="{{route('exam.create')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                     <div class="row">
                                        <div class="col-md-4">
                                            <label>@lang('Select Semester')</label>
                                            <select class="form-select" name="semester_id">
                                                @isset($semesters)
                                                    @foreach ($semesters as $semester)
                                                    <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>@lang('Course')</label>
                                            <select onchange="getCourses(this);" class="form-select" name="class1_id">
                                                <option value=""> @lang('Please select one')</option>
                                                @isset($classes)
                                                    @foreach ($classes as $school_class)
                                                    <option data-class="{{$school_class['class_id']}}" data-section="{{$school_class['section_id']}}" data-course="{{$school_class['course_id']}}" value="{{$school_class['id']}}">{{$school_class['class_name']}}  {{$school_class['section_name']}}  {{$school_class['course_name']}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <input type="hidden" id="class_id" name="class_id">
                                        <input type="hidden" id="section_id" name="section_id">
                                        <input type="hidden" id="course_id" name="course_id">

                                        <div class="col-md-4">
                                            <label>@lang('Exam name')</label>
                                            <input type="text" class="form-control" required name="exam_name" placeholder="ej: Cuestionario, Oral.." aria-label="ej: Cuestionario, Oral..">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mt-2">
                                            <label for="inputStarts" class="form-label">@lang('Starts')</label>
                                            <input type="datetime-local" required class="form-control" id="inputStarts" name="start_date" placeholder="Starts">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label for="inputEnds" class="form-label">@lang('Ends')</label>
                                            <input type="datetime-local" required class="form-control" id="inputEnds" name="end_date" placeholder="Ends">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label class="form-label">@lang('Total Marks')</label>
                                            <input type="text" class="form-control" required name="total_marks" placeholder="ej: 10" aria-label="Cuestionario, Oral, Final, ...">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label class="form-label">@lang('Pass Marks')</label>
                                            <input type="text" class="form-control" required name="pass_marks" placeholder="ej: 7" aria-label="Cuestionario, Oral, Final, ...">
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th width="20%" scope="col">@lang('Course')</th>
                                        <th width="10%" scope="col">@lang('Semester')</th>
                                        <th width="20%" scope="col">@lang('Nivel')</th>
                                        <th width="20%" scope="col">@lang('Name')</th>
                                        <th width="10%" scope="col">@lang('Starts')</th>
                                        <th width="10%" scope="col">@lang('Ends')</th> 
                                        <th width="10%" scope="col">@lang('Total Marks')</th>
                                        <th width="10%" scope="col">@lang('Pass Marks')</th>                                                     
                                        <th width="10%" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyDocentes">
                                    @isset($exams)
                                        @foreach ($exams as $exam)
                                        <tr>
                                            <td>{{$exam->course->course_name}} </td>
                                            <td>{{$exam->semester->semester_name}}</td>
                                            <td>{{$exam->schoolClass->class_name}}, {{$exam->section->section_name}} </td>
                                            <td>{{$exam->exam_name}}</td>  
                                            <td>{{$exam->start_date->format('d/m/Y')}}</td>
                                            <td>{{$exam->end_date->format('d/m/Y')}}</td> 
                                            <td align="center">{{$exam->rule->total_marks}}</td>
                                            <td align="center">{{$exam->rule->pass_marks}}</td>                                                  
                                            <td>
                                                <div class="btn-group" role="group">
                                                @can('edit exams rule')
                                                    <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" role="button" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> @lang('View Rule')</a>
                                                @endcan
                                                @can('delete exams')
                                                    <button onClick="javascript:Eliminar(this);" type="button" class="btn btn-sm btn-danger"> @lang('Delete')</button>
                                                @endcan 
                                                </div>                                                     
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
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>

    $('#inputStarts').on('blur',function(){
        $('#inputEnds').val($('#inputStarts').val());
    })

    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var class_id = obj.options[obj.selectedIndex].getAttribute('data-class');
        var section_id = obj.options[obj.selectedIndex].getAttribute('data-section');
        var course_id = obj.options[obj.selectedIndex].getAttribute('data-course');

        $('#class_id').val(class_id);
        $('#section_id').val(section_id);
        $('#course_id').val(course_id);


    }

    function Eliminar(me){
        Swal.fire("Oops!... opción no disponible para este usuario DEMO", "", "error");
    }    
</script>
@endsection
