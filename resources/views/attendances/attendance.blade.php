@extends('layouts.app')

@section('content')
<style type="text/css">
table {
    display: table;
    overflow-x: auto;
}
</style>
<link rel="stylesheet" href="{{ asset('css/fullcalendar5.9.0.min.css') }}">
<script src="{{ asset('js/fullcalendar5.9.0.main.min.js') }}"></script>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-calendar2-week"></i> @lang('View Attendance')
                    </h1>
                    <h5><i class="bi bi-person"></i> @lang('Student Name'): {{$student->first_name}} {{$student->last_name}}</h5>
                     @include('session-messages')
                     @can('view users')
                    <!--nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('student.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Students')</a>
                        </ol>
                    </nav-->
                    @endcan
                    <div class="row mt-3">
                        <div class="card col bg-white p-3 border shadow-sm">
                            <div id="attendanceCalendar"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="card col bg-white border shadow-sm p-3" >
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Context')</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>
                                                @if ($attendance->status == "on")
                                                    <span class="badge bg-success">@lang('PRESENT')</span>
                                                @elseif ($attendance->status == "off")
                                                    <span class="badge bg-danger">@lang('ABSENT')</span>
                                                @elseif ($attendance->status == "tarde")
                                                    <span class="badge bg-warning">@lang('LATE')</span>
                                                @endif
                                                
                                            </td>
                                            <td>{{$attendance->fecha->format('d/m/Y')}}</td>
                                            <td>{{($attendance->section == null)?$attendance->course->course_name:$attendance->section->section_name}}</td>

                                            @can('edit attendances')
                                            <td>
                                                <select name="status_{{$attendance->id}}" id="status_{{$attendance->id}}" class="form-control">
                                                  <option value="{{$attendance->status}}">
                                                    @if($attendance->status == 'on')
                                                        Presente
                                                    @elseif ($attendance->status == 'off')
                                                        Ausente
                                                    @elseif ($attendance->status == 'tarde')
                                                        Llegada Tarde
                                                    @endif        
                                                </option>
                                                  <option value="on">Presente</option>
                                                  <option value="tarde">Llegada Tarde</option>
                                                  <option value="off">Ausente</option>
                                                </option>
                                                </select>
                                            </td>
                                            <td>    
                                                <button data-id="{{$attendance->id}}" onClick="javascript:Grabar(this);" type="button" class="btn btn-sm btn-primary">Actualizar</button>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@php
$events = array();
if(count($attendances) > 0){
    foreach ($attendances as $attendance){
        if($attendance->status == "on"){
            $events[] = ['title'=> "Presente", 'start' => $attendance->fecha, 'color'=>'green'];
        } 
        if ($attendance->status == "tarde") {
            $events[] = ['title'=> "Llegada Tarde", 'start' => $attendance->fecha, 'color'=>'orange'];
        }
        if ($attendance->status == "off") {
            $events[] = ['title'=> "Ausente", 'start' => $attendance->fecha, 'color'=>'red'];
        }
    }
}
@endphp
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('attendanceCalendar');
    var attEvents = @json($events);
                            
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 480,
        events: attEvents,
    });
    calendar.render();
});

function Grabar(me){

    let id  = $(me).data('id');
    let valor = $('#status_'+id).val();


    url = '{{route("attendance.modificar")}}'
    $.ajax({
    method: 'POST',
    type: 'json',
    url: url,
    data:{id:id,valor:valor},
    headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    }).done(function(response) {
            window.location.reload();
    });
}

</script>
@endsection
