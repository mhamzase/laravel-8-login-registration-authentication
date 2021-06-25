@extends('master')
@section('title', 'User Dashboard')
@section('dashboard')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    You are Logged In
                </div>
            </div>
        </div>
    </div>
</div>
@endsection