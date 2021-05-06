@extends('layouts.app')
@section('title','Customer Web App')
@section('content')
<div class="content-wrapper" style="background-color:white;">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="margin: auto !important ;">
                <div class="card " style="width: 100%;    padding: 100% 37px; padding-top: 0;">
                    <div class="msg_card_header">

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


                        <div class="row msg_box">
                            <div class=" col-sm-1 " style="max-width: 5.333333% !important;">
                                <img src="../img/profile.svg" alt="Avatar" style="width:40px;border-radius: 30%;" />
                            </div>
                            <div class="col-sm-10 msg_content" style="">

                                <div class="msg_header">
                                    <h3 class=""><b>Mr.robin</b></h3>&nbsp;&nbsp;


                                </div>


                                <div class="mail" style="">
                                    marie@mail.com
                                </div>
                                <div class="msg_status msg click_shake" style="">
                                    quick reply
                                </div>
                                <div class="msg_body msg" style=" ">
                                    Hello. How are you today?Hello. How are you today?
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum
                                </div>
                                <div class="div_box msg">
                                </div>
                                <div class="msg_footer msg">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                                </div>
                                <a class="btn btn-info msg_button msg" id="reply" href="javascript:;" data-toggle="modal" data-target="#compose_popup_content">
                                    REPLY
                                </a>
                            </div>
                            <div class="col-sm-1 msg_time" style="">
                                11:00
                            </div>




                        </div>

                    </div>

                </div>

            </div>
        </div>


</div>


</section>
<!-- /.content -->
</div>
@endsection
