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
                        <i class="bi bi-person-lines-fill"></i> @lang('Administrative')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page" onclick="window.history.back();">@lang('Return to') @lang('Administratives')</li>
                        </ol>
                    </nav>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="card bg-light">
                                    <div class="px-5 pt-2">
                                        @if (isset($administrative->photo))
                                            <img src="{{asset('/storage'.$administrative->photo)}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @else
                                            <img src="{{asset('imgs/profile.png?v=1.0')}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$administrative->first_name}} {{$administrative->last_name}}</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">@lang('Role'): {{$administrative->role}}</li>
                                        <li class="list-group-item">@lang('Document'): {{$administrative->document}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="p-3 mb-3 border rounded bg-white">
                                    <h6>@lang('Administrative Information')</h6>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">@lang('First Name'):</th>
                                                <td>{{$administrative->first_name}}</td>
                                                <th>@lang('Last Name'):</th>
                                                <td>{{$administrative->last_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Email'):</th>
                                                <td>{{$administrative->email}}</td>
                                                <th scope="row">@lang('Nationality'):</th>
                                                <td>{{$administrative->nacionalidad->nombre}}</td>
                                            </tr>
                                            <tr>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Address'):</th>
                                                <td>{{$administrative->address}}</td>
                                                <th>@lang('Address2'):</th>
                                                <td>{{$administrative->address2}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('City'):</th>
                                                <td>{{$administrative->city}}</td>
                                                <th>@lang('Zip'):</th>
                                                <td>{{$administrative->zip}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Phone'):</th>
                                                <td>{{$administrative->phone}}</td>
                                                <th>@lang('Gender'):</th>
                                                <td>{{$administrative->gender}}</td>
                                            </tr>
                                            <tr>
                                            </tr>
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
