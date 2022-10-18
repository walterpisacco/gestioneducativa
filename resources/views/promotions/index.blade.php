@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-sort-numeric-up-alt"></i>  @lang('Promote Class Section')
                    </h1>
                    <div class="mb-4 mt-4">
                        <form action="{{route('promotions.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-select" name="class_id" required>
                                        @isset($previousSessionClasses)
                                            <option selected disabled> @lang('Please select one')</option>
                                            @foreach ($previousSessionClasses as $school_class)
                                            <option value="{{$school_class->schoolClass->id}}">{{$school_class->schoolClass->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i>  @lang('Load List')</button>
                                </div>
                            </div>
                        </form>
<div class="p-3 mb-4 border bg-light shadow-sm card">
    <div class="row">
        <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Section Name')</th>
                                    <th scope="col"> @lang('Promotion Status')</th>
                                    <th scope="col"> @lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($previousSessionSections)
                                    @foreach ($previousSessionSections as $previousSessionSection)
                                    <tr>
                                        <td>{{$previousSessionSection->section->section_name}}</td>
                                        <td>{{($currentSessionSectionsCounts > 0)?'Promovido': 'No Promovido'}}</td>
                                        <td>
                                            @if ($currentSessionSectionsCounts > 0)
                                                No necesita acciones
                                            @else
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('promotions.create', ['previousSessionId' => $previousSessionId,'previous_section_id' => $previousSessionSection->section->id, 'previous_class_id' => $class_id])}}" role="button" class="btn btn-sm btn-success"><i class="bi bi-sort-numeric-up-alt"></i>  @lang('Promote')</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
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
@endsection
