@extends('layouts.app')
@section('title','Customer Web App')
{{-- @include('home.navbar') --}}

@section('content')
<div class="content-wrapper" id="content" style="background: white;">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav mr-auto">
            <form class="form-inline ml-0 navform ">
                <div class="input-group search_form input-group-sm">
                    <input type="text" placeholder="&#xF002; Search" class="form-control form-control-navbar" style="font-family:Arial, FontAwesome;height: 35px;border-radius: 5px !important;" />
                </div>
            </form>

        </ul>
        <!-- Right navbar links -->
        <ul class=" navbar-nav ml-auto">
            <li class="nav-item">
                <div class="" style="font-size: 20px;">
                    &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                </div>
            </li>
            <li class="nav-item">
                <img src="../img/profile.svg" alt="Avatar" id="profile_img" style="width:40px" class="float-right" />

            </li>
            <p class="verified_text text-capitalize">&#x1f514; not verified </p>
        </ul>
    </nav>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="padding: 0 !important;">

                <div class="card dashboard_msg_list" style="width: 100%;padding: 20px;padding-top: 0;">
                    <div class="msg_card_header">
                        <div class="card-tools" style="float: left;">
                            <input type="checkbox" class="msg_mark" id="msg_mark">&nbsp;&nbsp;&nbsp;&nbsp;
                            {{-- <i class="material-icons">&#xe5d5;</i> --}}
                            <span class="refresh">↻</span>
                        </div>
                        <div class="card-tools" style="float: right;">
                            <div class="pagination">
                                {{-- <a href="#" class="active">1</a> --}}
                                <a href="#" class="">1</a>
                                <a href="#">of</a>
                                <a href="#">3</a>
                            </div>

                            <div class="pagination pagination_symbol">
                                <a href="#">❮</a>
                                <a href="#">❯</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="cart-body inbox ">
                        <div>
                            <input type="checkbox" class="checkbox" name="check-1" value="check-1" id="check-1">
                            <div class="row msg_box  unread_msg" onclick="window.location.href='/home/msg_box'">
                                <div class=" col-sm-1" style="max-width: 5.333333% !important;padding-left: 0;padding-right: 0;">

                                    <img src="../img/Group 99.svg" alt="Avatar" style="width:40px;border-radius: 30%;" ; />
                                </div>
                                <div class="col-sm-9" style="">

                                    <h5><b>Mr.robin</b></h5>
                                    <p class="msg_subjct bold hide_line float-left">Lorem ipsum dolor :</p>
                                    <p class="float-left hide_line"> Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you todayHello. How are you today?Hello. How are you todayssHello. How are you today?Hello. How are you today</p>
                                </div>
                                <div class="col-sm-2 right_align" style="">
                                    just now
                                </div>

                            </div>
                            <hr style="">
                        </div>
                        <div>
                            <input type="checkbox" name="check-2" value="check-2" id="check-2" class="checkbox">
                            <div class="row msg_box  unread_msg" onclick="window.location.href='/home/msg_box'">
                                <div class=" col-sm-1" style="max-width: 5.333333% !important;padding-left: 0;padding-right: 0;">

                                    <img src="../img/Group 99.svg" alt="Avatar" style="width:40px;border-radius: 30%;" ; />
                                </div>
                                <div class="col-sm-9" style="">

                                    <h5><b>Mr.robin</b></h5>
                                    <p class="msg_subjct bold hide_line float-left">Lorem ipsum dolor :</p>
                                    <p class="float-left hide_line"> Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you todayHello. How are you today?Hello. How are you todayssHello. How are you today?Hello. How are you today</p>
                                </div>
                                <div class="col-sm-2 right_align" style="">
                                    just now
                                </div>

                            </div>
                            <hr style="">
                        </div>

                        <div>
                            <input type="checkbox" name="check-3" value="check-3" id="check-3" class="checkbox">
                            <div class="row msg_box" onclick="window.location.href='/home/msg_box'">


                                <div class=" col-sm-1" style="max-width: 5.333333% !important;padding-left: 0;padding-right: 0;">
                                    <img src="../img/Group 99.svg" alt="Avatar" style="width:40px;border-radius: 30%;" ; />
                                </div>
                                <div class="col-sm-9" style="">

                                    <h5><b>Mr.robin</b></h5>
                                    <p class="msg_subjct bold hide_line float-left">Lorem ipsum dolor :</p>
                                    <p class="float-left hide_line"> Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you todayHello. How are you today?Hello. How are you todayssHello. How are you today?Hello. How are you today</p>
                                </div>
                                <div class="col-sm-2 right_align" style="">
                                    just now
                                </div>

                            </div>
                            <hr style="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection
