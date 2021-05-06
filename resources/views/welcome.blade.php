@extends('layouts.welcomehome')
@section('title', 'Customer Web App')


@section('content')
    <div class="clo_2 col-md-4 col-sm-12 d-flex flex-column justify-content-center ">
        <div class="dot_img">
            <img src="../img/dotdot.svg" alt="Avatar" style="" />
        </div>
        <div class="clo_2_sub content" style="">

            <form action="{{ url('/customer-login') }}" method="post">
                @csrf
                <h2 style="text-align: center">SIGN IN</h2>
                <div class="form-group">

                    <label for="email">Email </label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email"
                        placeholder="Enter email">
                    @if (session('message_email'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ session('message_email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    @if (session('message_pass'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ session('message_pass') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class=" hover_shake btn btn-info btn-block">Sign In</button>
            </form>
            <br>
            <div class="center">
                <small class="form-text text-muted">
                    <a href="{{ url('forgetp') }}">Forgot Password?</a>
                    OR <a href="{{ url('sign_up') }}"> Sign UP</a>
                </small>
            </div>
            <div id="me"></div>


        </div>
    </div>

@endsection
