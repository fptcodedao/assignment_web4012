@extends('admin.layouts.auth')

@section('title', 'Đăng Nhập')

@section('content')
    <form class="card auth_form" action="#" method="post">
        <div class="header">
            <img class="logo" src="{{asset('assets/images/logo.svg')}}" alt="">
            <h5>Log in</h5>
        </div>
        <div class="body">
            {{csrf_field()}}
            <div class="input-group mb-3 @error('email') border border-warning @enderror">
                <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Username">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="input-group mb-3 @error('password') border border-warning @enderror">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <div class="input-group-append">
                    <span class="input-group-text"><a href="#" class="forgot" title="Forgot Password"><i class="zmdi zmdi-lock"></i></a></span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="checkbox">
                <input id="remember_me" type="checkbox">
                <label for="remember_me">Remember Me</label>
            </div>
            <button class="btn btn-primary btn-block waves-effect waves-light">Sign In</button>
{{--            <div class="signin_with mt-3">--}}
{{--                <p class="mb-0">or Sign Up using</p>--}}
{{--                <button class="btn btn-primary btn-icon btn-icon-mini btn-round facebook"><i class="zmdi zmdi-facebook"></i></button>--}}
{{--                <button class="btn btn-primary btn-icon btn-icon-mini btn-round twitter"><i class="zmdi zmdi-twitter"></i></button>--}}
{{--                <button class="btn btn-primary btn-icon btn-icon-mini btn-round google"><i class="zmdi zmdi-google-plus"></i></button>--}}
{{--            </div>--}}
        </div>
    </form>
@stop
