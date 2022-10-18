@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-diagram-2"></i>  @lang('Edit Section')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{url('classes')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Sections')</a>
                        </ol>
                    </nav>                    
                    @include('session-messages')
                    <div class="row">
                        <form class="col-md-4 offset-md-4" action="{{route('school.section.update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            <input type="hidden" name="section_id" value="{{$section_id}}">
                            <div class="mb-3">
                                <label for="section_name" class="form-label"> @lang('Section Name')</label>
                                <input class="form-control" id="section_name" name="section_name" type="text" value="{{$section->section_name}}">
                            </div>
                            <div class="mb-3">
                                <label for="room_no" class="form-label"> @lang('Room number')</label>
                                <input class="form-control" id="room_no" name="room_no" type="text" value="{{$section->room_no}}">
                            </div>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i>  @lang('Save')</button>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection