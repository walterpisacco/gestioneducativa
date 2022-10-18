@extends('layouts.app')

@section('content')
<style>
/* .table th:first-child,
.table td:first-child {
  position: relative;
  background-color: #f8f9fa;
} */
</style>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Teacher')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('teacher.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Teachers')</a>
                        </ol>
                    </nav>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="card bg-light">
                                    <div class="px-5 pt-2">
                                        @if (isset($teacher->photo))
                                            <img src="{{asset('/storage'.$teacher->photo)}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @else
                                            <img src="{{asset('imgs/profile.png?v=1.0')}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$teacher->first_name}} {{$teacher->last_name}}</h5>
                                    </div>
                                    @if(Auth::user()->role != "student" and Auth::user()->role != "padre")
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">@lang('Document'): {{$teacher->document}}</li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="p-3 mb-3 border rounded bg-white">
                                    <h6>@lang('Teacher Information')</h6>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">@lang('First Name'):</th>
                                                <td>{{$teacher->first_name}}</td>
                                                <th>@lang('Last Name'):</th>
                                                <td>{{$teacher->last_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Email'):</th>
                                                <td>{{$teacher->email}}</td>
                                                <th scope="row">@lang('Nationality'):</th>
                                                <td>{{$teacher->nacionalidad->nombre}}</td>
                                            </tr>
                                            <tr>
                                            </tr>
                                            @if(Auth::user()->role != "student" and Auth::user()->role != "padre")
                                            <tr>
                                                <th scope="row">@lang('Address'):</th>
                                                <td>{{$teacher->address}}</td>
                                                <th>@lang('Address2'):</th>
                                                <td>{{$teacher->address2}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('City'):</th>
                                                <td>{{$teacher->city}}</td>
                                                <th>@lang('Zip'):</th>
                                                <td>{{$teacher->zip}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Phone'):</th>
                                                <td>{{$teacher->phone}}</td>
                                                <th>@lang('Gender'):</th>
                                                <td>{{$teacher->gender}}</td>
                                            </tr>
                                            @endif
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
