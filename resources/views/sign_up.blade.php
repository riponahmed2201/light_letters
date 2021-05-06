@extends('layouts.welcomehome')
@section('title','Customer Web App')
{{-- @include('home.navbar') --}}

@section('content')
<div class="clo_2 col-md-4 col-sm-12">
    <div class="clo_2_sub content" style="padding-top: 47px;">
        <form method="post" action="{{url('/create-customer/')}}">
            @csrf
            <h2 style="text-align: center">SIGN UP</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <label for="first_name">First name </label>
                <input type="text" class="form-control" id="first_name" aria-describedby="first_name" name="first_name" placeholder="Enter First name">
            </div>
            <div class="form-group">
                <label for="last_name">Last name </label>
                <input type="text" class="form-control" id="last_name" aria-describedby="last_name" name="last_name" placeholder="Enter Last name">
            </div>
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="email" aria-describedby="email" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
            </div>
{{--            <a href="{{ url('home/profile')}}" class="btn btn-info btn-block" role="button"> Sign UP--}}
{{--            </a>--}}
            {{-- <button onclick="window.location.href='/home'" type="submit">SIGN IN</button>  --}}
            <button type="submit" id="submitButton" class="btn btn-info btn-block">Sign Up</button>
        </form>
            <br>
            <div class="center">
                <small class="form-text text-muted">
                    OR <br><a href="{{ url('welcome')}}"> Sign IN</a>
                </small>
            </div>
    </div>
</div>

@endsection
