@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col-md-8 offset-md-2 ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-calendar4-range"></i> @lang('Routines')</h1>
                    @php
                        function getDayName($weekday) {
                            if($weekday == 1) {
                                return "LUNES";
                            } else if($weekday == 2) {
                                return "MARTES";
                            } else if($weekday == 3) {
                                return "MIERCOLES";
                            } else if($weekday == 4) {
                                return "JUEVES";
                            } else if($weekday == 5) {
                                return "VIERNES";
                            } else if($weekday == 6) {
                                return "SÁBADO";
                            } else if($weekday == 7) {
                                return "DOMINGO";
                            } else {
                                return "Sin Días";
                            }
                        }
                    @endphp
                    @if(count($routines) > 0)
                    <div class="card bg-white p-3 border shadow-sm">
                        <table class="table table-bordered text-center">
                            </thead>
                            <tbody>
                                @foreach($routines as $day => $courses)
                                    <tr><th>{{getDayName($day)}}</th>
                                        @php
                                            $courses = $courses->sortBy('start');
                                        @endphp
                                        @foreach($courses as $course)
                                            <td>
                                                <span>{{$course->course->course_name}}</span>
                                                <div>{{$course->start}} - {{$course->end}}</div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-3 bg-white border shadow-sm">@lang('No routine').</div>
                    @endif
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
