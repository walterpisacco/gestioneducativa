@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-diagram-2"></i> @lang('Edit Class')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{url('classes')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Classes')</a>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <div class="">
                                <form class="" action="{{route('school.class.update')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="class_id" value="{{$class_id}}">
                                    <div class="mb-3">
                                        <label>@lang('Class Name')</label>
                                        <input class="form-control" id="class_name" name="class_name" type="text" value="{{$schoolClass->class_name}}">
                                    </div>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
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