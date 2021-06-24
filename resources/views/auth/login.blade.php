@extends('master')

@section('login')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">

                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                        @endif

                        @if(Session::has('success_email_verify'))
                        <div class="alert alert-success">
                            {{Session::get('success_email_verify')}}
                        </div>
                        @endif

                        @if(Session::has('already_email_verify'))
                        <div class="alert alert-primary">
                            {{Session::get('already_email_verify')}}
                        </div>
                        @endif

                        @if(Session::has('error_email_verify'))
                        <div class="alert alert-danger">
                            {{Session::get('error_email_verify')}}
                        </div>
                        @endif

                        @if(Session::has('login_error'))
                        <div class="alert alert-danger">
                            {{Session::get('login_error')}}
                        </div>
                        @endif

                        @if(Session::has('not_allowed_dashboard'))
                        <div class="alert alert-danger">
                            {{Session::get('not_allowed_dashboard')}}
                        </div>
                        @endif

                        



                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" id="email_address" class="form-control" name="email" value="{{old('email')}}" autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" value="{{old('password')}}" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4 text-right">
                                    <a href="">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endSection