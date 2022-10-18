@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Edit Teacher')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('teacher.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Teachers')</a>
                        </ol>
                    </nav>

                    @include('session-messages')

                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <form action="{{route('teacher.update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="document" class="form-label">@lang('Document')</label>
                                    <input type="text" class="form-control" id="document" name="document" placeholder="Sin puntos ni guiones" required value="{{$teacher->document}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="inputFirstName" class="form-label">@lang('First Name')</label>
                                    <input type="text" class="form-control" id="inputFirstName" name="first_name" placeholder="Nombres" required value="{{$teacher->first_name}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputLastName" class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="Apellidos" required value="{{$teacher->last_name}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputEmail" class="form-label">@lang('Email')</label>
                                    <input type="email" class="form-control" id="inputEmail" name="email" required value="{{$teacher->email}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">@lang('Photo')</label>
                                    <input class="form-control" type="file" id="formFile" onchange="previewFile()">
                                    <div style="max-width: 200px;" id="previewPhoto"></div>
                                    <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputState" class="form-label">@lang('Gender')</label>
                                    <select id="inputState" class="form-select" name="gender" required>
                                        <option value="Hombre" {{($teacher->gender == 'Hombre')?'selected':null}}>@lang('Male')</option>
                                        <option value="Mujer" {{($teacher->gender == 'Mujer')?'selected':null}}>@lang('Female')</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputNationality" class="form-label">@lang('Nationality')</label>
                                    <select class="form-select" aria-label="Class" name="nationality" id="inputNationality" required>
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option value="{{$nacionalidad->id}}" {{$nacionalidad->id == $teacher->nationality ?'selected="selected"':''}}>{{$nacionalidad->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPhone" class="form-label">@lang('Phone')</label>
                                    <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="+54 11......" required value="{{$teacher->phone}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="inputAddress" class="form-label">@lang('Address')</label>
                                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="Feijoo 816, Barracas" required value="{{$teacher->address}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputAddress2" class="form-label">@lang('Address 2')</label>
                                    <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="" value="{{$teacher->address2}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputCity" class="form-label">@lang('City')</label>
                                    <input type="text" class="form-control" id="inputCity" name="city" placeholder="CABA..." required value="{{$teacher->city}}">
                                </div>
                                <div class="col-md-1">
                                    <label for="inputZip" class="form-label">@lang('Zip')</label>
                                    <input type="text" class="form-control" id="inputZip" name="zip" value="{{$teacher->zip}}">
                                </div>
                            </div>
                            <div class="row mb-4">

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-person-check"></i> @lang('Update')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

@include('components.photos.photo-input')
@endsection
