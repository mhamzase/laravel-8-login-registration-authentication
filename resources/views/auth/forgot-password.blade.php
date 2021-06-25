@extends('master')
@section('title', 'Forgot Password')
@section('forgot_password')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forgot Password</div>
                    <div class="card-body">

                        @if(Session::has('send_email_success'))
                        <div class="alert alert-success">
                            {{Session::get('send_email_success')}}
                        </div>
                        @endif

                        @if(Session::has('send_email_error'))
                        <div class="alert alert-danger">
                            {{Session::get('send_email_error')}}
                        </div>
                        @endif


                        <form action="{{ route('forgotPassword.post') }}" method="POST">
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

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    Send Email
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