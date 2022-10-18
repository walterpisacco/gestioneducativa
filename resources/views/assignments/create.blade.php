@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-file-post"></i>  @lang('Create Assignment')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="row mt-4">
                        <div class="col-md-4 offset-md-4">
                            <div class="card p-3 border bg-light shadow-sm">
                                <form action="{{route('assignment.store')}}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="class_id" value="{{request()->query('class_id')}}">
                                    <input type="hidden" name="semester_id" value="{{request()->query('semester_id')}}">
                                    <input type="hidden" name="course_id" value="{{request()->query('course_id')}}">
                                    <input type="hidden" name="section_id" value="{{request()->query('section_id')}}">
                                    <div class="mb-3">
                                        <label for="assignment-name" class="form-label"> @lang('Assignment Name')</label>
                                        <input type="text" class="form-control" id="assignment-name" name="assignment_name" placeholder="" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="assignment-file" class="form-label"> @lang('Assignment File')</label>
                                        <input type="file" name="file" class="form-control" id="assignment-file" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" required>
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i>  @lang('Create')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
