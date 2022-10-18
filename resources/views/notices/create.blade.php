@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-megaphone"></i> @lang('Create Notice')</h1>
                    @include('session-messages')
                    <div class="row">
                        <div class="p-3 card border shadow-sm">
                            <form action="{{route('notice.store')}}" method="POST">
                                    @csrf
                                @if($student_id > 0)
                                <input id="student_id" name="student_id" type="hidden" value="{{$student_id}}">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="student_notify" id="student_check">
                                    <label class="form-check-label" for="student_check">@lang('Student')</label>
                                </div>                            
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="tutor_notify" id="tutor_check">
                                    <label class="form-check-label" for="tutor_check">@lang('Tutor')</label>
                                </div>
                                @else                                    
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="admin_notify" id="admin_check">
                                    <label class="form-check-label" for="admin_check">@lang('Administratives')</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="preceptores_notify" id="preceptores_check">
                                    <label class="form-check-label" for="preceptores_check">@lang('Preceptors')</label>
                                </div>                            
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="docentes_notify" id="docentes_check">
                                    <label class="form-check-label" for="docentes_check">@lang('Teachers')</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="alumnos_notify" id="alumnos_check">
                                    <label class="form-check-label" for="alumnos_check">@lang('Students')</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="padres_notify" id="padres_check">
                                    <label class="form-check-label" for="padres_check">@lang('Tutors')</label>
                                </div> 
                                @endif                           
                                @include('components.ckeditor.editor', ['name' => 'notice'])
                                <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Send')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
