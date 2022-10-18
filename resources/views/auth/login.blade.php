@extends('layouts.applogin')

@section('content')
<body>
    <div class="container">
        <div class="row login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" style="height: 100vh" id="kt_login">
             <div class="col-lg-6 order-1 d-media-none logo" >
                <img style="max-height: 100vh;" src= "{{asset('imgs/bg-4.jpg')}}">
            </div>

            <div class="col-lg-6 order-1 d-media-none overflow-hidden">
                <div class="login-form login-signin">
                <a href="{{route('home')}}"><img src="{{asset('imgs/logo-2.png')}}" style="margin-bottom: 50px;width: 400px;" class="" alt="" /></a>
                        <form style="max-width:400px" method="POST" action="{{ route('login') }}">
                            @csrf
                          @include('session-messages')  
                        <div class="form-group">
                            <select class="form-select" id="inputSchool" name="school" required>
                                <option selected value="0">@lang('Select School')</option>
                                @foreach ($schools as $school)
                                    <option value="{{$school->id}}" >{{$school->name}}</option>
                                @endforeach
                                </select>
                        </div>

                        <div class="form-group">
                            <input value="admin@aktis.com.ar" class="form-control form-control-solid  py-4 px-6" type="email"
                                placeholder="{{__('Email Address')}}" name="email" autocomplete="off" />

                        </div>
                        <div class="form-group">
                            <input value="password" class="form-control form-control-solid py-4 px-6" type="password"
                                placeholder="{{__('Password')}}" name="password" autocomplete="off" />

                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <button type="submit" id="kt_login_signin_submit"
                                class="btn btn-success font-weight-bold px-9 my-3">@lang('Sign In')</button>
                            <a href="{{route('password.request')}}" class="text-dark-50 text-hover-primary my-3 mr-2"
                                id="kt_login_forgot">{{__('Forgot Your Password?')}}</a>
                        </div>
                        <!--div  class="form-group">
                            <a href="{{ url('auth/google') }}" style="margin-top: 0px !important;background: green;color: #ffffff;padding: 5px;border-radius:7px;" class="ml-2">
                              <strong>Google Login</strong>
                            </a>
                        </div-->
                        <div>
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection