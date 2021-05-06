@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper my_content_wrapper" id="content">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white text-dark ml-md-0 ">
        <!-- Left navbar links -->
        <ul class="navbar-nav mr-auto">
            {{-- left hidden botton for aside manu  --}}
            <li class="nav-item aside_pushmenu_bar">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if($customerInfo->status)
                <div>
                    <p class="verified_text text-capitalize">&#x1f514; {{$customerInfo->status}} </p>
                </div>
                @endif
            </li>
            <li class="nav-item">
                <p class="nav_sign">
                    &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                </p>
            </li>

            <li class="nav-item dropdown">
                <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Profile_pic" class="top_nav_img dropdown-toggle" id="profile_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                <div class="dropdown-menu profile_dropdownMenu" aria-labelledby="profile_dropdownMenu">
                    <div class="container">
                        <div class="row" style="padding: 13px 0">
                            <div class="col-12 main-section text-center">

                                <div class="row user-detail">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" class="top_nav_img2 rounded-circle img-thumbnail">
                                        <h5 class="bold">{{$customerInfo->first_name}} {{$customerInfo->last_name}}</h5>
                                        <p class="small">{{$customerInfo->email}}</p>

                                        <a href="{{ url('home/profile')}}" class="btn btn-light profile_link btn-sm"><b>Manage Profile<b></a>
                                        <br>
                                        <hr>
                                        <br>
                                    </div>
                                </div>
                                <div class="row user-social-detail">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <form action="{{url('/customer-logout')}}" method="post" class="btn btn-light logout_link btn-sm">
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-sm ">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

        </ul>



    </nav>
    <!-- /.navbar -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-lg-12 col-sm-12 col-md-12 py-2">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus magnam rem aut quis consequuntur odit repudiandae facere. Incidunt nesciunt eveniet porro! Fuga rem, atque nam debitis eos laudantium inventore, dolore laboriosam officiis sequi vel adipisci reprehenderit maiores corrupti distinctio deserunt sint quod rerum animi. Unde consequatur adipisci, rerum repudiandae incidunt modi explicabo officia eius nisi tenetur voluptatibus sed autem maiores expedita ipsum tempore vel aliquid aspernatur ad reiciendis maxime? Et qui amet, veritatis debitis cumque perferendis labore reprehenderit perspiciatis dolore harum consectetur officiis vero consequuntur placeat. Cum beatae perferendis dolorem! Ducimus aperiam odit quidem praesentium mollitia ad placeat ratione illo?
                    
                   
                </div>
                <!-- ./col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
