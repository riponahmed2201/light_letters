@extends('layouts.welcomehome')
@section('title','Customer Web App')
{{-- @include('home.navbar') --}}

@section('content')
    <div class="clo_2">
        <div class="clo_2_sub content" style="padding-top: 137px;">
            <form action="{{url('/create-new-password/'.$email)}}" method="post">
                @csrf
                @method('PUT')
                <h2 style="text-align: center">Reset Password</h2>
                <div class="form-group">
                    <label>New Password </label>
                    <input type="text" name="password" class="form-control" id="password" placeholder="Enter New Password">
                </div>
                <div class="form-group">
                    <label>Confirm Password </label>
                    <input type="text" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter Confirm Password">
                </div>
                <button type="submit" class="btn btn-info btn-block">Submit</button>
            </form>
        </div>
    </div>
@endsection
