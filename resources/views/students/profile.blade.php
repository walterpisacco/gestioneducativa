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
                        <i class="bi bi-person-lines-fill"></i> @lang('Student')
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a href="{{route('student.list.show')}}" class="breadcrumb-item active" aria-current="page">@lang('Return to') @lang('Students')</a>
                        </ol>
                    </nav>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="card bg-light">
                                    <div class="px-5 pt-2">
                                        @if (isset($student->photo))
                                        <img src="{{asset('/storage'.$student->photo)}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @else
                                        <img src="{{asset('imgs/profile.png?v=1.0')}}" class="rounded-3 card-img-top" alt="Profile photo">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$student->first_name}} {{$student->last_name}}</h5>
                                        <p class="card-text">@lang('Id Card Number'): {{$promotion_info->id_card_number}}</p>
                                        <p class="card-text">@lang('Document'): {{$student->document}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="p-3 mb-3 border rounded bg-white">
                                    <h6>@lang('Student Information')</h6>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">@lang('First Name'):</th>
                                                <td>{{$student->first_name}}</td>
                                                <th>@lang('Last Name'):</th>
                                                <td>{{$student->last_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Email'):</th>
                                                <td>{{$student->email}}</td>
                                                <th>@lang('Birthday'):</th>
                                                <td>{{$student->birthday}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Nationality'):</th>
                                                <td>{{$student->nacionalidad->nombre}}</td>
                                                <th>@lang('Religion'):</th>
                                                <td>{{$student->religion}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Address'):</th>
                                                <td>{{$student->address}}</td>
                                                <th>@lang('Address2'):</th>
                                                <td>{{$student->address2}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('City'):</th>
                                                <td>{{$student->city}}</td>
                                                <th>@lang('Zip'):</th>
                                                <td>{{$student->zip}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Blood Type'):</th>
                                                <td>{{$student->blood_type}}</td>
                                                <th>@lang('Phone'):</th>
                                                <td>{{$student->phone ?? null}} </td>
                                                <td align="left">
                                                    <a target="_blank" href="https://wa.me/ {{$student->phone ?? null}}" class="">
                                                        <img style="width: 25px;padding-bottom: 5px;" src="{{ asset('imgs/whatsapp.png') }}" />
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang('Gender'):</th>
                                                <td colspan="3">{{$student->gender}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 mb-3 border rounded bg-white">
                                    <h6>@lang("Tutor Information")</h6>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">@lang("Name"):</th>
                                                <td colspan="2">{{$student->parent_info->father_name ?? null}} {{$student->parent_info->father_last_name ?? null}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang("Phone"):</th>
                                                <td>
                                                    {{$student->parent_info->father_phone ?? null}}
                                                </td>
                                                <td align="left">
                                                    <a target="_blank" href="https://wa.me/ {{$student->parent_info->father_phone ?? null}}" class="">
                                                        <img style="width: 25px;padding-bottom: 5px;" src="{{ asset('imgs/whatsapp.png') }}" />
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">@lang("Email"):</th>
                                                <td colspan="2">{{$student->parent_info->father_email ?? null}}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 mb-3 border rounded bg-white">
                                    <h6>@lang('Academic Information')</h6>
                                    <table class="table table-responsive mt-3">
                                        <tbody>
                                            <tr>
                                                <th scope="row">@lang('Class'):</th>
                                                <td>{{$promotion_info->section->schoolClass->class_name}}</td>
                                                <th>@lang('Section'):</th>
                                                <td>{{$promotion_info->section->section_name}}</td>
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