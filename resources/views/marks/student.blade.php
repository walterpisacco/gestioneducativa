@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-cloud-sun"></i> @lang('Course Marks')
                    </h1>

                    <h5>@lang('Course'): {{$course_name}}</h5>
                    <div class="card mb-4 mt-4 p-3 bg-white border shadow-sm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="%20" scope="col">@lang('Date')</th>
                                    <th width="%20" scope="col">@lang('Exam Name')</th>
                                    <th width="%20" scope="col">@lang('Pass Marks')</th>
                                    <th width="%20" scope="col">@lang('Mark')</th>
                                    <th width="%20" scope="col">@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marks as $mark)
                                    <tr>
                                        <td>{{$mark->exam->start_date->format('d/m/Y')}}</td>
                                        <td>{{$mark->exam->exam_name}}</td>
                                        <td>{{$mark->exam->rule->pass_marks}}</td>
                                        <td>
                                            @if ($mark->marks > 0)
                                                {{$mark->marks}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($mark->marks == -1)
                                                <span class="badge bg-success">NO EVALUADO</span>
                                            @elseif ($mark->marks == -2)
                                               <span class="badge bg-warning">AUSENTE</span> 
                                            @elseif ($mark->exam->rule->pass_marks > $mark->marks)
                                                <span class="badge bg-danger">DESAPROBADO</span> 
                                            @else
                                                <span class="badge bg-success">APROBADO</span>     
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(count($final_marks) > 0)
                    <h5>@lang('Final Result')</h5>
                    <div class="card bg-white border mt-4 p-3 shadow-sm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Total Marks')</th>
                                    <th scope="col">@lang('Grade Points')</th>
                                    <th scope="col">@lang('Grade')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($final_marks)
                                    @foreach ($final_marks as $mark)
                                    <tr>
                                        <td>{{$mark->final_marks}}</td>
                                        <td>{{$mark->getAttribute('point')}}</td>
                                        <td>{{$mark->getAttribute('grade')}}</td>
                                    </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
