@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-calendar2-week-fill"></i> @lang('View Attendance')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>
                    @if(request()->query('course_name'))
                        <h3><i class="bi bi-compass"></i> @lang('Course'): {{request()->query('course_name')}} </h3>
                    @elseif(request()->query('section_name'))
                        <h3><i class="bi bi-diagram-2"></i> @lang('Section'): {{request()->query('section_name')}} </h3>
                    @endif
                    <div class="row mt-4">
                         <div class="card bg-white border p-3 shadow-sm">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Student Name')</th>
                                        <th scope="col">@lang("Today's Status")</th>
                                        <th scope="col">@lang('Total Attended')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        @php
                                            $total_attended = \App\Models\Attendance::where('student_id', $attendance->student_id)->where('session_id', $attendance->session_id)->count();
                                        @endphp
                                        <tr>
                                            <td>{{$attendance->student->first_name}} {{$attendance->student->last_name}}</td>
                                            <td>
                                                @if ($attendance->status == "on")
                                                    <span class="badge bg-success">@lang('PRESENT')</span>
                                                @elseif ($attendance->status == "off")
                                                    <span class="badge bg-danger">@lang('ABSENT')</span>
                                                @elseif ($attendance->status == "tarde")
                                                    <span class="badge bg-warning">@lang('LATE')</span>
                                                @endif
                                                
                                            </td>
                                            <td>{{$total_attended}}</td>
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
@endsection
