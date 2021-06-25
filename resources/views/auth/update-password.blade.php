@extends('master')
@section('title', 'Update Password')
@section('update_password')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Password</div>
                    <div class="card-body">


                        @if(Session::has('error_password_same'))
                        <div class="alert alert-danger">
                            {{Session::get('error_password_same')}}
                        </div>
                        @endif

                        @if(Session::has('token'))
                            {{$token = Session::get('token')}}
                        @endif

                        <form action="{{ route('updatePassword.post') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{$token}}" name="token" id="token" />
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" value="{{old('password')}}" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="cpassword" class="form-control" value="{{old('cpassword')}}" name="cpassword">
                                    @if ($errors->has('cpassword'))
                                    <span class="text-danger">{{ $errors->first('cpassword') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    Update Password
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