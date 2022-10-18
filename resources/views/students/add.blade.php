@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Add Student') </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('student.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Students')</a>
                        </ol>
                    </nav>                        
                    @include('session-messages')
                    <p class="text-primary">
                        <small><i class="bi bi-exclamation-diamond-fill me-2"></i> @lang('Remember to create related Class and Section before adding student')</small>
                    </p>
                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <form id="frmAlumno">
                            @csrf
                            <div class="row mb-4 g-3">
                                <div class="col-md-3">
                                        <label for="inputIdCardNumber" class="form-label">@lang('Id Card Number')</label>
                                        <input type="text" class="form-control" id="inputIdCardNumber" required name="id_card_number" placeholder="" value="{{old('id_card_number')}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="document" class="form-label">@lang('Document')</label>
                                    <input type="text" class="form-control" id="document" name="document" value="" placeholder="Sin puntos ni guiones" required value="{{old('document')}}">                                
                                </div>
                            </div>
                            <div class="row mb-4 g-2">
                                <div class="col-md-3">
                                    <label for="inputFirstName" class="form-label">@lang('First Name')</label>
                                    <input type="text" class="form-control" id="inputFirstName"  name="first_name" placeholder="" required value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputLastName" class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="" required value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputEmail4" class="form-label">@lang('Email')</label>
                                    <input type="email" class="form-control" id="inputEmail4" name="email" required value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputPassword4" class="form-label">@lang('Password')</label>
                                    <input type="password" class="form-control" id="inputPassword4" name="password" value=""  required>
                                </div>
                            </div>
                            <div class="row mb-4 g-2">
                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">@lang('Photo')</label>
                                    <input class="form-control" type="file" id="formFile" onchange="previewFile()">
                                    <div style="max-width:200px" id="previewPhoto"></div>
                                    <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputBirthday" class="form-label">@lang('Birthday')</label>
                                    <input type="date" class="form-control" id="inputBirthday" name="birthday" placeholder="Birthday" required value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputState" class="form-label">@lang('Gender')</label>
                                    <select id="inputState" class="form-select" name="gender" required>
                                        <option value="Hombre" {{old('gender') == 'Hombre' ? 'selected' : ''}}>@lang('Male')</option>
                                        <option value="Mujer" {{old('gender') == 'Mujer' ? 'selected' : ''}}>@lang('Female')</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputNationality" class="form-label">@lang('Nationality')</label>
                                    <select class="form-select" id="inputNationality" name="nationality" required>
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option value="{{$nacionalidad->id}}" >{{$nacionalidad->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div> 
                            </div>
                            <div class="row mb-4 g-2">                               
                                <div class="col-md-3">
                                    <label for="inputAddress" class="form-label">@lang('Address')</label>
                                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="ej: Moreno 200" required value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputAddress2" class="form-label">@lang('Address 2')</label>
                                    <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="" value="{{old('address2')}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputCity" class="form-label">@lang('City')</label>
                                    <input type="text" class="form-control" id="inputCity" name="city" placeholder="ej: CABA" required value="">
                                </div>
                                <div class="col-md-1">
                                    <label for="inputZip" class="form-label">@lang('Zip')</label>
                                    <input type="text" class="form-control" id="inputZip" name="zip" value="{{old('zip')}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPhone" class="form-label">@lang('Phone')</label>
                                    <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="ej: +54 11......" value="{{old('phone')}}">
                                </div> 
                            </div>
                            <div class="row mb-4 g-2" style="display:none;">                               
                                <div class="col-md-2">
                                    <label for="inputBloodType" class="form-label">@lang('BloodType')</label>
                                    <select id="inputBloodType" class="form-select" name="blood_type" required>
                                        <option {{old('blood_type') == 'A+' ? 'selected' : ''}}>A+</option>
                                        <option {{old('blood_type') == 'A-' ? 'selected' : ''}}>A-</option>
                                        <option {{old('blood_type') == 'B+' ? 'selected' : ''}}>B+</option>
                                        <option {{old('blood_type') == 'B-' ? 'selected' : ''}}>B-</option>
                                        <option {{old('blood_type') == 'O+' ? 'selected' : ''}}>O+</option>
                                        <option {{old('blood_type') == 'O-' ? 'selected' : ''}}>O-</option>
                                        <option {{old('blood_type') == 'AB+' ? 'selected' : ''}}>AB+</option>
                                        <option {{old('blood_type') == 'AB-' ? 'selected' : ''}}>AB-</option>
                                        <option {{old('blood_type') == 'other' ? 'selected' : ''}}>@lang('Other')</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputReligion" class="form-label">@lang('Religion')</label>
                                    <select id="inputReligion" class="form-select" name="religion" required>
                                        <option {{old('religion') == 'Christianity' ? 'selected' : ''}}>@lang('Christianity')</option>
                                        <option {{old('religion') == 'Evangelist' ?  : ''}}>@lang('Evangelist')</option>
                                        <option {{old('religion') == 'Islam' ? 'selected' : ''}}>@lang('Islam')</option>
                                        <option {{old('religion') == 'Hinduism' ? 'selected' : ''}}>@lang('Hinduism')</option>
                                        <option {{old('religion') == 'Buddhism' ? 'selected' : ''}}>@lang('Buddhism')</option>
                                        <option {{old('religion') == 'Judaism' ? 'selected' : ''}}>@lang('Judaism')</option>
                                        <option {{old('religion') == 'Others' ? 'selected' : ''}}>@lang('Other')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h6>@lang("Parent's Information")</h6>
                            </div>    
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <label for="documentFather" class="form-label">@lang('Document')</label>
                                    <input type="text" class="form-control" id="documentFather" name="father_document" placeholder="Sin puntos ni guiones" value="">                                
                                </div>
                                <div class="col-md-2">
                                    <label for="inputFatherName" class="form-label">@lang('Name')</label>
                                    <input type="text" class="form-control" id="inputFatherName" name="father_name" placeholder=""  value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputFatherName" class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="inputFatherName" name="father_last_name" placeholder=""  value="">
                                </div>                                
                                <div class="col-md-2">
                                    <label for="inputFatherPhone" class="form-label">@lang("Phone")</label>
                                    <input type="text" class="form-control" id="inputFatherPhone" name="father_phone" placeholder="ej: +54 11......"  value="{{old('father_phone')}}">
                                </div>                                
                                <div class="col-md-3">
                                    <label for="inputFatherEmail" class="form-label">@lang("Email")</label>
                                    <input type="text" class="form-control" id="inputFatherEmail" name="father_email" placeholder=""  value="">
                                </div> 
                                <div class="col-md-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked name="father_notify" id="father_notify_check">
                                        <label class="form-check-label" for="father_notify_check">Recibir Notificaciones</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4"  style="display:none">
                                <div class="col-md-3">
                                    <label for="inputNationality" class="form-label">@lang('Nationality')</label>
                                    <select class="form-select" id="inputFatherNationality" name="father_nationality" >
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option value="{{$nacionalidad->id}}" >{{$nacionalidad->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div>                                
                            </div>
                            <div class="row mb-4" style="display: none;">
                                <div class="col-4-md">
                                    <label for="inputParentAddress" class="form-label">@lang('Address')<sup></sup></label>
                                    <input type="text" class="form-control" id="inputParentAddress" name="parent_address" placeholder="Moreno 200.."  value="{{old('parent_address')}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h6>@lang('Academic Information')</h6>
                                <div class="col-md-4">
                                    <label for="inputAssignToClass" class="form-label">@lang('Assign to class'):</label>
                                    <select onchange="getSections(this);" class="form-select" id="inputAssignToClass" name="class_id" required>
                                        @isset($school_classes)
                                            <option selected disabled>@lang('Please select one')</option>
                                            @foreach ($school_classes as $school_class)
                                                <option value="{{$school_class->id}}" >{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="inputAssignToSection" class="form-label">@lang('Assign to section'):</label>
                                    <select class="form-select" id="inputAssignToSection" name="section_id" required>
                                    </select>
                                </div>
                                <div class="col-md-12" style="display:none">
                                    <label for="inputBoardRegistrationNumber" class="form-label">@lang('Board registration No').</label>
                                    <input type="text" class="form-control" id="inputBoardRegistrationNumber" name="board_reg_no" placeholder="" value="{{old('board_reg_no')}}">
                                </div>
                                <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            </div>
                            <div class="row mb-4">
                                <div class="col-12-md">
                                    <hr>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12-md">
                                    <button type="button" id="btnGrabaAlumno" class="btn btn-sm btn-success"><i class="bi bi-person-plus"></i> @lang('Add')</button>
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
<script>
    $('#btnGrabaAlumno').on('click',function(){
        let url = "{{route('school.student.create')}}";
        //docente_teacher_id  = $('#docente_teacher_id').val();
        class_id = $("#inputAssignToClass").val();
        section_id = $("#inputAssignToSection").val(); 


        if(class_id == null || section_id == ''){
            Swal.fire("Oops!... Complete todos los campos marcados con un (*) para poder continuar", "", "error");
            return;
        }

        data = $('#frmAlumno :input').serializeArray();

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url,
            data:{data:JSON.stringify(data)},
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $('#asig_course_name').val('');
                }else{
                    Swal.fire("Oops!..."+response.texto, "", "error");
                    return;
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    function getSections(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('inputAssignToSection');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': '','section_name': 'Seleccione un opción'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }
</script>
@include('components.photos.photo-input')
@endsection
