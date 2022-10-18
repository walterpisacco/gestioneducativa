@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-journal-medical"></i> @lang('Change Password')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Change Password')</li>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="card col-6 border p-3 shadow-sm">
                        <form action="{{route('password.update')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="old-password" class="form-label">@lang('Old Password')</label>
                                <input class="form-control" id="old-password" name="old_password" type="password" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">@lang('New Password')</label>
                                <input class="form-control" id="new-password" name="new_password" type="password" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">@lang('Confirm new Password')</label>
                                <input class="form-control" id="new-password" name="new_password_confirmation" type="password" placeholder="">
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