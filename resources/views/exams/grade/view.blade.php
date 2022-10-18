@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-file-text"></i> @lang('View Grading Systems')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('View Grading Systems')</li>
                        </ol>
                    </nav>
                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Class')</th>
                                    <th scope="col">@lang('Semester')</th>
                                    <th scope="col">@lang('Starts At')</th>
                                    <th scope="col">@lang('Ends At')</th>  
                                    @can('edit grading systems')                                    
                                    <th scope="col">@lang('Actions')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @isset($gradingSystems)
                                    @foreach ($gradingSystems as $gradingSystem)
                                    <tr>
                                        <td>{{$gradingSystem->system_name}}</td>
                                        <td>{{$gradingSystem->schoolClass->class_name}}</td>
                                        <td>{{$gradingSystem->semester->semester_name}}</td>
                                        <td>
                                            @foreach ($gradingSystem->reglas as $regla)
                                                {{$regla->start_at}}
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($gradingSystem->reglas as $regla)
                                                {{$regla->end_at}}
                                            @endforeach
                                        </td> 
                                        @can('edit grading systems')                                       
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(Auth::user()->role != "student" and Auth::user()->role != "padre")
                                                <a href="{{route('exam.grade.system.rule.create', ['grading_system_id' => $gradingSystem->id])}}" role="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i> @lang('Add Rule')</a>
                                                @endif
                                                <a href="{{route('exam.grade.system.rule.show', ['grading_system_id' => $gradingSystem->id])}}" role="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> @lang('View Rules')</a>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
