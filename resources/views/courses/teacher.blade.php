@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-journal-medical"></i> @lang('My Courses')    </h1>
                    <h6>@lang('Filter list by'):</h6>
                    <div class="col-md-12 mb-4 mt-4">
                        <div class="card p-3 mt-3 bg-white border shadow-sm">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="20%" scope="col">@lang('Course')</th>
                                        <th width="20%" scope="col">@lang('Class')</th>
                                        <th width="20%" scope="col">@lang('Section')</th>
                                        <th width="40%" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($courses)
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>{{$course->course->course_name}}</td>
                                            <td>{{$course->schoolClass->class_name}}</td>
                                            <td>{{$course->section->section_name}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('attendance.create.show', [
                                                        'class_id' => $course->schoolClass->id,
                                                        'section_id' => $course->section->id,
                                                        'course_id' => $course->course->id,
                                                        'class_name' => $course->schoolClass->class_name,
                                                        'section_name' => $course->section->section_name,
                                                        'course_name' => $course->course->course_name])}}" role="button" class="btn btn-sm btn-success"> @lang('Attendance')</a>
                                                    <a href="{{route('attendance.list.show', [
                                                        'class_id' => $course->schoolClass->id,
                                                        'section_id' => $course->section->id,
                                                        'course_id' => $course->course->id,
                                                        'class_name' => $course->schoolClass->class_name,
                                                        'section_name' => $course->section->section_name,
                                                        'course_name' => $course->course->course_name])}}" role="button" class="btn btn-sm btn-primary">@lang('View Attendance')</a>
                                                <div style="display:none">
                                                    <a href="{{route('assignment.create', [
                                                        'class_id' => $course->schoolClass->id,
                                                        'section_id' => $course->section->id,
                                                        'course_id' => $course->course->id,
                                                        'semester_id' => request()->query('semester_id')])}}" role="button" class="btn btn-sm btn-primary">@lang('Create Assignment')</a>
                                                    <a href="{{route('assignment.list.show', ['course_id' => $course->course->id])}}" role="button" class="btn btn-sm btn-primary">@lang('View Assignments')</a>
                                                </div>    
                                                    <a href="{{route('course.mark.create', [
                                                        'class_id' => $course->schoolClass->id,
                                                        'class_name' => $course->schoolClass->class_name,
                                                        'section_id' => $course->section->id,
                                                        'section_name' => $course->section->section_name,
                                                        'course_id' => $course->course->id,
                                                        'course_name' => $course->course->course_name,
                                                        'semester_id' => $selected_semester_id])}}" role="button" class="btn btn-sm btn-danger">@lang('Give Marks')</a>
                                                <div style="display:none">
                                                    <a href="{{route('course.mark.list.show', [
                                                        'class_id' => $course->schoolClass->id,
                                                        'class_name' => $course->schoolClass->class_name,
                                                        'section_id' => $course->section->id,
                                                        'section_name' => $course->section->section_name,
                                                        'course_id' => $course->course->id,
                                                        'course_name' => $course->course->course_name,
                                                        'semester_id' => $selected_semester_id])}}" role="button" class="btn btn-sm btn-primary">@lang('View Final Results')</a>
                                                </div>
                                                        <a style="background-color: black;" href="{{route('course.syllabus.index', ['course_id' => $course->course->id])}}" role="button" class="btn btn-sm btn-primary">@lang('Syllabus')</a>                                  
                                                    <a href="#" role="button" class="btn btn-sm btn-warning"  tabindex="-1" aria-disabled="true">@lang('Message')</a>

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
@endsection
