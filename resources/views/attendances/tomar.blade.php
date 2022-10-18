@extends('layouts.app')

@section('content')
<style type="text/css">
table {
    display: table;
    overflow-x: auto;
}
</style>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-calendar2-week"></i> @lang('Take Attendance')
                    </h1>
                    <div class="mt-4">@lang('Current Date and Time'): {{ date('Y-m-d H:i:s') }}</div>
                    @include('session-messages')
                    <div class="row mt-4">
                        <div class="col-md-10 offset-md-1">
                            <div class="card bg-white border p-3 shadow-sm">
                                @csrf
                                    <div class="row mt-4">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input 
                                                    id="fecha" 
                                                    name="fecha" 
                                                    data-dd-format="Y-m-d"
                                                    class="form-control date datedropper-init" 
                                                    type="text"
                                                    data-lang="es" 
                                                    data-large-mode="true" 
                                                    data-large-default="true"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <select onchange="getSections(this);" class="form-select" id="class_id" name="class_id" required>
                                                @isset($school_classes)
                                                    <option selected value="" disabled>@lang('Please select one')</option>
                                                    @foreach ($school_classes as $school_class)
                                                        <option value="{{$school_class->id}}" >{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-4">
                                            <select onchange="Buscar(this);"  class="form-select" id="section_id" name="section_id" required>
                                            </select>
                                        </div>
                                        <button onCLick="javascript:Buscar();"  style="display:none" id="btnBuscar" type="button" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i> @lang('Load List')</button>
                                    </div>
                                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                        <input type="hidden" name="course_id" value="0">

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="20%" scope="col"></th>
                                                        <th width="20%" scope="col">@lang('Document')</th>
                                                        <th width="40%" scope="col">@lang('Student Name')</th>
                                                        <th width="20%" class="text-center" scope="col">@lang('Present')</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyAlumnos">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<script>

    function guardar(){
        let url = "{{route('attendances.store')}}";
        fecha  = $('#fecha').val();
        class_id    = $('#class_id').val();
        section_id  = $('#section_id').val();

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

            
    }

    function getSections(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('section_id');
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

//$(document).ready(function(){

    function Buscar(){
        let url = "{{route('attendance.asistencia')}}";
        session_id = $('#session_id').val();
        class_id = $('#class_id').val();
        section_id = $('#section_id').val();

        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?class_id='+class_id+'&section_id='+section_id,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                fila = '';
                response.student_list.forEach( function(valor, indice, array) {
                    fila += '<input type="hidden" name="student_ids[]" value="'+valor.student_id+'">';
                    fila += '<tr>';
                    fila += '<td align="center" widht="10%">';
                    fila += '<img style="height:40px" src="../storage'+valor.student.photo+'" class="rounded" alt="Profile picture">'; 
                    fila += '</td>';                   
                    fila += '<th scope="row">'+valor.student.document+ '</th>';
                    fila += '<td>'+valor.student.first_name+ ' '+valor.student.last_name+'</td>';
                    fila += '<td>';
                    fila += '<select name="'+valor.student_id+'" class="form-control tag">';
                    fila += '<option value="on">Presente</option>';
                    fila += '<option value="tarde">Llegada Tarde</option>';
                    fila += '<option value="off">Ausente</option>';
                    fila += '</option>';
                    fila += '</select>';
                    fila += '</td>';
                    fila += '</tr>';
                });

                    fila += '<tr>';
                    fila += '<td colspan="5">';
                    fila += '<button id="btnGrabaAsistencia" onClick="javascript:guardar();" type="button" class="btn btn-success"><i class="bi bi-check2"></i> @lang("Save")</button>';
                    fila += '</td>';
                    fila += '</tr>';
                    
                $('#tbodyAlumnos').html(fila);
            }).fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    }      
//})

    $('.date').dateDropper({});
</script>
@endsection
