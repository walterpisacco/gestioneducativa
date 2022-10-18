@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-file-text"></i> @lang('Exam Rules')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('exam.create.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Exams')</a>
                        </ol>
                    </nav>
                    <div class="card mb-4 bg-white border shadow-sm p-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Total Marks')</th>
                                    <th scope="col">@lang('Pass Marks')</th>
                                    <th scope="col">@lang('Marks Distribution Note')</th>
                                    <th scope="col">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exam_rules as $exam_rule)
                                <tr>
                                    <td>{{$exam_rule->total_marks}}</td>
                                    <td>{{$exam_rule->pass_marks}}</td>
                                    <td>{{$exam_rule->marks_distribution_note}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a type="button" href="{{route('exam.rule.edit', ['exam_rule_id' => $exam_rule->id])}}" class="btn btn-sm btn-warning"><i class="bi bi-pen"></i> @lang('Edit')</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
