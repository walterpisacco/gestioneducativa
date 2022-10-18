@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-journal-medical"></i> @lang('Edit Course')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url()->previous()}}">@lang('Courses')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Edit Course')</li>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="row">
                        <form class="col-6" action="{{route('school.course.update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            <input type="hidden" name="course_id" value="{{$course_id}}">
                            <div class="mb-3">
                                <label for="course_name" class="form-label">@lang('Course Name')</label>
                                <input class="form-control" id="course_name" name="course_name" type="text" value="{{$course->course_name}}">
                            </div>
                            <div class="mb-3">
                                <label for="course_type" class="form-label">@lang('Course Type')</label>
                                <select class="form-select" id="course_type" name="course_type" aria-label="Course type">
                                    <option value="General" {{($course->course_type == 'Core')? 'selected' : ''}}>@lang('Core')</option>
                                    <option value="Optional" {{($course->course_type == 'Optional')? 'selected' : ''}}>@lang('Optional')</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection