@extends('layouts.welcomehome')
@section('title','Customer Web App')
{{-- @include('home.navbar') --}}

@section('content')
    <div class="clo_2">
        <div class="clo_2_sub content" style="padding-top: 137px;">
            <form action="{{url('/token-check')}}" method="POST">
                @csrf
                <h2 style="text-align: center">Submit Your Token</h2>
                <div class="form-group">
{{--                    <label >Token </label>--}}
                    <input type="text" name="token" class="form-control" id="token" placeholder="Enter token">
                </div>
                    <input  type="hidden" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ $email }}">
                <button type="submit" class="btn btn-info btn-block">Submit Token</button>
            </form>
        </div>
    </div>
@endsection
