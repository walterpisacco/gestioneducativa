@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-journal-medical"></i> @lang('My Courses')
                    </h1>
                    @can('view courses')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>
                    @endcan
                    <div class="col-md-8 offset-md-2 mb-4 mt-4">
                        <div class="card p-3 mt-3 bg-white border shadow-sm">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="80%" scope="col">@lang('Course Name')</th>
                                        <th width="20%" scope="col">@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($courses)
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>{{$course->course_name}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('course.mark.show', [
                                                        'course_id' => $course->id,
                                                        'course_name' => $course->course_name,
                                                        'semester_id' => $course->semester_id,
                                                        'class_id'  => $class_info->class_id,
                                                        'session_id' => $course->session_id,
                                                        'section_id' => $class_info->section_id,
                                                        'student_id' => Auth::user()->id
                                                        ])}}" role="button" class="btn btn-sm btn-primary"><i class="bi bi-cloud-sun"></i> @lang('View Marks')</a>
                                                    <a href="{{route('course.syllabus.index', ['course_id'  => $course->id])}}" role="button" class="btn btn-sm btn-success"><i class="bi bi-journal-text"></i> @lang('View Syllabus')</a>
                                                    <a href="{{route('assignment.list.show', ['course_id' => $course->id])}}" role="button" class="btn btn-sm btn-warning"><i class="bi bi-file-post"></i> @lang('View Assignments')</a>
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
