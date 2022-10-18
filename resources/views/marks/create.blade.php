@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-cloud-sun"></i> @lang('Give Marks')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>
                    @include('session-messages')
                    @if ($academic_setting['marks_submission_status'] == "on")
                    <p class="text-primary">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Marks Submission Window is open now').
                    </p>
                    @endif
                    <p class="text-primary">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Final Marks submission should be done only once in a Semester when the Marks Submission Window is open').
                    </p>
                    @if ($final_marks_submitted)
                    <p class="text-success">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Marks are submitted')
                    </p>
                    @endif
                    <h3><i class="bi bi-diagram-2"></i> {{request()->query('class_name')}}, {{request()->query('section_name')}}, 
                     @lang('Course'): {{request()->query('course_name')}}</h3>
                    @if (!$final_marks_submitted && count($exams) > 0 && $academic_setting['marks_submission_status'] == "on")
                        <div class="col-3 mt-3">
                            <a type="button" href="{{route('course.final.mark.submit.show', ['class_id' => $class_id, 'class_name' => request()->query('class_name'), 'section_id' => $section_id, 'section_name' => request()->query('section_name'), 'course_id' => $course_id, 'course_name' => request()->query('course_name'), 'semester_id' => $semester_id])}}" class="btn btn-outline-primary" onclick="return confirm('Are you sure, you want to submit final marks?')"><i class="bi bi-check2"></i> Submit Final Marks</a>
                        </div>
                    @endif
                    <div class="card bg-white border p-3 shadow-sm">
                    <form action="{{route('course.mark.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">@lang('Student Name')</th>
                                            @isset($exams)
                                                @foreach ($exams as $exam)
                                                <th style="width:5%" class="text-center" scope="col">
                                                    <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$exam->exam_name}} ">{{$exam->start_date->format('d/m/Y')}}</a>
                                                <!--div class="form-check form-switch text-center">
                                                    <input data-examen="{{$exam->id}}" class="form-check-input" onchange="javascript:habilitarExamen(this)" type="checkbox" name="examen_check" id="examen_check">
                                                    <label class="form-check-label" for="examen_check">Calificar</label>
                                                </div-->
                                                </th>
                                                @endforeach 
                                            @endisset
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($exams)
                                                @isset($students_with_marks)
                                                    @foreach ($students_with_marks as $id => $students_with_mark)
                                                        @php
                                                            $markedExamCount = 0;
                                                        @endphp
                                                    <tr>
                                                        <td style="width:20%">{{$students_with_mark[0]->student->first_name}} {{$students_with_mark[0]->student->last_name}}
                                                        </td>
                                                        @foreach ($students_with_mark as $st)
                                                            <td style="width:5%">
                                                                <select name="student_mark[{{$students_with_mark[0]->student->id}}][{{$exams[$markedExamCount]->id}}]"  class="form-control tag examen_{{$exams[$markedExamCount]->id}}">
                                                                  <option value="-1">No Evaluado</option>
                                                                  <option value="-2">Ausente</option>
                                                                  @if($exams[$markedExamCount]->id == $st->exam_id)
                                                                  <option value="{{$st->marks}}" selected>
                                                                    @if ($st->marks == -1)
                                                                        No Evaluado
                                                                    @elseif ($st->marks == -2)
                                                                        Ausente
                                                                    @else
                                                                        {{$st->marks}}
                                                                    @endif                                                                     
                                                                    </option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            
                                                            @php
                                                                $markedExamCount++;
                                                            @endphp


                                                        @endforeach
                                                        @php
                                                            $students_with_markCount = count($students_with_mark);
                                                            $examCount = count($exams);
                                                            $gt = 0;
                                                            if($students_with_markCount < $examCount) {
                                                                $gt = $examCount - $students_with_markCount;
                                                            }
                                                        @endphp
                                                        @for ($i = 0; $i < $gt; $i++)
                                                        {{$exams[$markedExamCount]->id}}
                                                            <td style="width:5%">
                                                                <select name="student_mark[{{$students_with_mark[0]->student->id}}][{{$exams[$markedExamCount]->id}}]"  class="form-control tag examen_{{$exams[$markedExamCount]->id}}">
                                                                  <option value="-1">No Evaluado</option>
                                                                  <option value="-2">Ausente</option>
                                                                  <option value="{{$st->marks}}" selected>
                                                                    @if ($st->marks == -1)
                                                                        No Evaluado
                                                                    @elseif ($st->marks == -2)
                                                                        Ausente
                                                                    @else
                                                                        {{$st->marks}}
                                                                    @endif                                                                     
                                                                </option>
                                                                </select>
                                                            </td>
                                                            @php
                                                                $markedExamCount++;
                                                            @endphp
                                                        @endfor
                                                    </tr>
                                                    @endforeach
                                                @endisset
                                            @endisset
                                            @if(count($students_with_marks) < 1)
                                                @foreach ($sectionStudents as $sectionStudent)
                                                    <tr>
                                                        <td style="width:20%">{{$sectionStudent->student->first_name}} {{$sectionStudent->student->last_name}}</td>
                                                        @isset($exams)
                                                            @foreach ($exams as $exam)
                                                                <td style="width:5%">
                                                                <select title="{{$sectionStudent->student->first_name}}" name="student_mark[{{$sectionStudent->student->id}}][{{$exam->id}}]" class="form-control tag examen_{{$exam->id}}">
                                                                  <option value="-1">No Evaluado</option>
                                                                  <option value="-2">Ausente</option>
                                                                </select>

                                                                </td>
                                                            @endforeach
                                                        @endisset
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <input type="hidden" name="studentCount" value="{{count($sectionStudents)}}">
                                            <!--input type="hidden" name="semester_id" value="{{$semester_id}}"-->
                                            <input type="hidden" name="class_id" value="{{$class_id}}">
                                            <input type="hidden" name="section_id" value="{{$section_id}}">
                                            <input type="hidden" name="course_id" value="{{$course_id}}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row justify-content-between mb-3"> --}}
                            @if(!$final_marks_submitted && count($exams) > 0)
                            <div class="col-12">
                                <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                            </div>
                            @else
                                @if($final_marks_submitted)
                                <div class="col-5">
                                    <p class="text-success">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('You have submitted Final Marks') <i class="bi bi-stars"></i>.
                                    </p>
                                </div>
                                @else
                                <div class="col-5">
                                    <p class="text-primary">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i><span style="color:red"> @lang('No existen examenes creados!!')</span>
                                    </p>
                                </div>
                                @endif
                            @endif
                            {{-- <div class="col-3">
                                <button type="button" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Submit Marks')</button>
                            </div> --}}
                        {{-- </div> --}}
                    </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

function habilitarExamen(me){
/*
    examenId = me.getAttribute('data-examen');

    if($(me).is(":checked")){
        $('.examen_'+examenId).attr('disabled',false);
    }else{
        $('.examen_'+examenId).attr('disabled',true);
    }
   */ 
}
$(".tag").select2({
  tags: true
});
</script>
@endsection