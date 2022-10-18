@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Edit Student')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('student.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Students')</a>
                        </ol>
                    </nav>

                    @include('session-messages')
                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <form  action="{{route('school.student.update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{$student->id}}">
                            <div class="row mb-4 g-3">
                                <div class="col-md-3">
                                    <label for="inputIdCardNumber" class="form-label">@lang('Id Card Number')</label>
                                    <input type="text" class="form-control" id="inputIdCardNumber" name="id_card_number" placeholder="" value="{{$promotion_info->id_card_number}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputFirstName" class="form-label">@lang('Document')</label>
                                    <input type="text" class="form-control" id="document" name="document" placeholder="Sin puntos ni guiones" required value="{{$student->document}}">
                                </div>
                            </div>                                
                            <div class="row mb-4 g-3">
                                <div class="col-md-3">
                                    <label for="inputFirstName" class="form-label">@lang('First Name')</label>
                                    <input type="text" class="form-control" id="inputFirstName" name="first_name" placeholder="First Name" required value="{{$student->first_name}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputLastName" class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="Last Name" required value="{{$student->last_name}}">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputEmail4" class="form-label">@lang('Email')</label>
                                    <input type="email" class="form-control" id="inputEmail4" name="email" required value="{{$student->email}}">
                                </div>
                               
                            </div>
                            <div class="row mb-4 g-3">
                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">@lang('Photo')</label>
                                    <input class="form-control" type="file" id="formFile" onchange="previewFile()">
                                    <div style="max-width:200px" id="previewPhoto"></div>
                                    <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                </div>                                
                                <div class="col-md-3">
                                    <label for="inputBirthday" class="form-label">@lang('Birthday')</label>
                                    <input type="date" class="form-control" id="inputBirthday" name="birthday" placeholder="Birthday" required value="{{$student->birthday}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputState" class="form-label">@lang('Gender')</label>
                                    <select id="inputState" class="form-select" name="gender" required>
                                        <option value="Hombre" {{($student->gender == 'Hombre')?'selected':null}}>@lang('Male')</option>
                                        <option value="Mujer" {{($student->gender == 'Mujer')?'selected':null}}>@lang('Female')</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputNationality" class="form-label">@lang('Nationality')</label>

                                    <select class="form-select" aria-label="Class" name="nationality" id="inputNationality" required>
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option value="{{$nacionalidad->id}}" {{$nacionalidad->id == $student->nationality ?'selected="selected"':''}}>{{$nacionalidad->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4 g-3">                                                                
                                <div class="col-md-3">
                                    <label for="inputAddress" class="form-label">@lang('Address')</label>
                                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="ej: Moreno 200" required value="{{$student->address}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputAddress2" class="form-label">@lang('Address 2')</label>
                                    <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="" value="{{$student->address2}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputCity" class="form-label">@lang('City')</label>
                                    <input type="text" class="form-control" id="inputCity" name="city" placeholder="ej: CABA" required value="{{$student->city}}">
                                </div>
                                <div class="col-md-1">
                                    <label for="inputZip" class="form-label">@lang('Zip')</label>
                                    <input type="text" class="form-control" id="inputZip" name="zip" value="{{$student->zip}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPhone" class="form-label">@lang('Phone')</label>
                                    <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="ej: +54 11....."  value="{{$student->phone}}">
                                </div>
                            </div>
                            <div class="row mb-4 g-3">                                
                                <div class="col-md-2">
                                    <label for="inputBloodType" class="form-label">@lang('BloodType')</label>
                                    <select id="inputBloodType" class="form-select" name="blood_type" required>
                                        <option value="A+" {{($student->blood_type == 'A+')?'selected':null}}>A+</option>
                                        <option value="A-" {{($student->blood_type == 'A-')?'selected':null}}>A-</option>
                                        <option value="B+" {{($student->blood_type == 'B+')?'selected':null}}>B+</option>
                                        <option value="B-" {{($student->blood_type == 'B-')?'selected':null}}>B-</option>
                                        <option value="O+" {{($student->blood_type == 'O+')?'selected':null}}>O+</option>
                                        <option value="O-" {{($student->blood_type == 'O-')?'selected':null}}>O-</option>
                                        <option value="AB+" {{($student->blood_type == 'AB+')?'selected':null}}>AB+</option>
                                        <option value="AB-" {{($student->blood_type == 'AB-')?'selected':null}}>AB-</option>
                                        <option value="Other" {{($student->blood_type == 'Other')?'selected':null}}>@lang('Other')</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputReligion" class="form-label">@lang('Religion')</label>
                                    <select id="inputReligion" class="form-select" name="religion" required>
                                        <option {{($student->religion == 'Christianity')?'selected':null}}>@lang('Christianity')</option>
                                        <option {{($student->religion == 'Evangelist')?'selected':null}}>@lang('Evangelist')</option>
                                        <option {{($student->religion == 'Islam')?'selected':null}}>@lang('Islam')</option>
                                        <option {{($student->religion == 'Hinduism')?'selected':null}}>@lang('Hinduism')</option>
                                        <option {{($student->religion == 'Buddhism')?'selected':null}}>@lang('Buddhism')</option>
                                        <option {{($student->religion == 'Judaism')?'selected':null}}>J@lang('udaism<')/option>
                                        <option {{($student->religion == 'Other')?'selected':null}}>@lang('Other')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h6>@lang("Parent's Information")</h6>
                                <input type="hidden" class="form-control" id="father_id" name="father_id" value="@if (isset($padre)){{$padre->id}}@endif">
                            </div>
                            <div class="row mb-4 g-3">
                                <div class="col-md-2">
                                    <label for="documentFather" class="form-label">@lang('Document')</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="father_document" 
                                        name="father_document" 
                                        placeholder="Sin puntos ni guiones"  
                                        value="@if (isset($padre)){{$padre->document}}@endif"
                                        required>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputFatherName" class="form-label">@lang('Name')</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father Name" required value="@if (isset($padre)){{$padre->first_name}}@endif">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputFatherName" class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="father_last_name" name="father_last_name" placeholder="" required value="@if (isset($padre)){{$padre->last_name}}@endif">
                                </div>                                     
                                <div class="col-md-2">
                                    <label for="inputFatherPhone" class="form-label">@lang("Phone")</label>
                                    <input type="text" class="form-control" id="father_phone" name="father_phone" placeholder="ej: +54 11....."  value="@if (isset($parent_info)){{$parent_info->father_phone}}@endif">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputFatherEmail" class="form-label">@lang('Email')</label>
                                    <input type="text" class="form-control" id="father_email" name="father_email" placeholder="" value="@if (isset($padre)){{$padre->email}}@endif">
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked name="father_notify" id="father_notify_check">
                                        <label class="form-check-label" for="father_notify_check">Recibir Notificaciones</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 g-3" style="display:none">
                                <div class="col-md-3">
                                    <label for="inputMotherName" class="form-label">@lang('Mother Name')</label>
                                    <input type="text" class="form-control" id="inputMotherName" name="mother_name" placeholder="Mother Name" value="{{$parent_info->mother_name}}">
                                </div>
                                <div class="col-3">
                                    <label for="inputMotherPhone" class="form-label">@lang("Mother's Phone")</label>
                                    <input type="text" class="form-control" id="inputMotherPhone" name="mother_phone" placeholder="ej: +54 11......"  value="{{$parent_info->mother_phone}}">
                                </div>
                                <div class="col-3">
                                    <label for="inputMotherEmail" class="form-label">@lang('Mother Email')</label>
                                    <input type="text" class="form-control" id="inputMotherName" name="mother_email" placeholder="" value="{{$parent_info->mother_email}}">
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked name="mother_notify" id="mother_notify_check">
                                        <label class="form-check-label" for="mother_notify_check">Recibir Notificaciones</label>
                                    </div>
                                </div>  
                            </div>
                            <div class="row mb-4 g-3">                                                             
                                <div class="col-4" style="display:none">
                                    <label for="inputParentAddress" class="form-label">@lang('Address')</label>
                                    <input type="text" class="form-control" id="inputParentAddress" name="parent_address" placeholder="ej: Moreno 200.."  value="{{$parent_info->parent_address}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12-md">
                                    <hr>
                                </div>
                            </div>                            
                            <div class="row mt-4">
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
