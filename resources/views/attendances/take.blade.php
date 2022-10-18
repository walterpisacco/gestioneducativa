@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-calendar2-week"></i> @lang('Take Attendance')
                    </h1>
                    @include('session-messages')
                    <h3><i class="bi bi-compass"></i>
                        {{request()->query('class_name')}}, 
                        @if ($academic_setting->attendance_type == 'course')
                            {{request()->query('course_name')}}
                        @else
                            {{request()->query('section_name')}}
                        @endif
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>  
                    <div class="row mt-4">
                        <div class="col-md-10 offset-md-1">
                            <div class="card bg-white border p-3 shadow-sm">
                                @csrf
                                <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                <input type="hidden" name="class_id" value="{{request()->query('class_id')}}">
                                @if ($academic_setting->attendance_type == 'course')
                                    <input type="hidden" name="course_id" value="{{request()->query('course_id')}}">
                                    <input type="hidden" name="section_id" value="0">
                                @else
                                    <input type="hidden" name="course_id" value="0">
                                    <input type="hidden" name="section_id" value="{{request()->query('section_id')}}">
                                @endif
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20%" scope="col">@lang('Photo')</th>
                                            <th width="30%" scope="col">@lang('Document')</th>
                                            <th width="30%" scope="col">@lang('Student Name')</th>
                                            <th width="20%" class="text-center" scope="col">@lang('Present')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAlumnos">
                                        @foreach ($student_list as $student)
                                        <input type="hidden" name="student_ids[]" value="{{$student->student_id}}">
                                        <tr>
                                            <th scope="row">
                                            @if (isset($student->student->photo))
                                                <img src="{{asset('/storage'.$student->student->photo)}}" class="rounded" alt="Profile picture" height="40" width="40">
                                            @else
                                               <img src="{{asset('/storage/photos/profile.png')}}" class="rounded" alt="Profile picture" height="40" width="40">
                                            @endif
                                            </th>
                                            <th scope="row">{{$student->student->document}}</th>
                                            <td>{{$student->student->first_name}} {{$student->student->last_name}}</td>

                                            <td>
                                                <select name="{{$student->student_id}}" class="form-control tag">
                                                  <option value="on">Presente</option>
                                                  <option value="tarde">Llegada Tarde</option>
                                                  <option value="off">Ausente</option>
                                                </option>
                                                </select>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if(count($student_list) > 0 && $attendance_count < 1)
                                <div class="mb-4">
                                    <button id="btnGrabaAsistencia" type="button" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Save')</button>
                                </div>
                                @else
                                    <p class="text-primary">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i><span style="color:red"> @lang('Ya se ha tomado asistencia a este curso!!')</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<script>

    $('#btnGrabaAsistencia').on('click',function(){
        let url = "{{route('attendances.store')}}";
        fecha  = "<?php echo date('Y-m-d') ?>";
        class_id    = "<?php echo request()->query('class_id') ?>";
        section_id  = "<?php echo request()->query('section_id') ?>";

        if(fecha == '' || class_id == null || section_id == ''){
            Swal.fire({
              icon: 'error',
              title: 'Seleccione todos los datos de la cabecera para poder tomar asistencia!!',
              showConfirmButton: false,
              timer: 1500
            });
            return;
        }

        objAsistencia = $('#tbodyAlumnos :input').serializeArray();

        $.ajax({
            method: 'POST',
            type: 'json',
            url: url,
            data:{fecha:fecha,class_id:class_id,section_id:section_id,course_id:0,asistencia:JSON.stringify(objAsistencia)},
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
                    })
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    })
                }

            }).fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();

            
    })

    $('.date').dateDropper({});
</script>

@endsection
