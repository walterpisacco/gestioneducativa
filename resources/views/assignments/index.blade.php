@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-journal-medical"></i> @lang('Assignments')
                    </h1>
                    @can('view courses')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Courses')</a>
                        </ol>
                    </nav>
                    @endcan
                    <div class="mb-4 mt-4">
                        <div class="card p-3 mt-3 bg-white border shadow-sm">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Assignment Name')</th>
                                        <th scope="col">@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $assignment)
                                        <tr>
                                            <td>{{$assignment->assignment_name}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{asset('storage/'.$assignment->assignment_file_path)}}" role="button" class="btn btn-sm btn-warning"><i class="bi bi-download"></i> @lang('Download')</a>
                                                </div>
                                            </td>
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
