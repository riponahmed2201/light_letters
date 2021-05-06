@extends('layouts.welcomehome')
@section('title','Customer Web App')
{{-- @include('home.navbar') --}}

@section('content')
 <div class="clo_2 col-md-4 col-sm-12 d-flex flex-column justify-content-center">
            <div class="clo_2_sub  content" >
                <form action="{{url('/reset-password')}}" method="post" ">
                    @csrf
                    <h2 style="text-align: center">Type your email</h2>
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email">
                    </div>
{{--                    <a href="{{ url('welcome')}}" class="btn btn-info btn-block" role="button"> Get the code--}}
{{--                    </a>--}}
                     {{--  <button onclick="window.location.href='/home'" type="submit">SIGN IN</button>  --}}
                    <button type="submit" class="btn btn-info btn-block">Get Reset Token</button>
                </form>
            </div>
        </div>

@endsection
