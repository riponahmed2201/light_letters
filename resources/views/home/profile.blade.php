@extends('layouts.app')

@section('content')


<div class="content-wrapper my_content_wrapper" id="content">
    {{-- top navbar --}}

    <nav class="main-header navbar navbar-expand navbar-white text-dark ml-md-0 ">
        <!-- Left navbar links -->

        <ul class="navbar-nav mr-auto">
            {{-- left hidden botton for aside manu  --}}
            <li class="nav-item aside_pushmenu_bar">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item ">
                <div class="nav-item ">

                    @if (isset($customerInfo->comment))
                    <div class="alert alert-danger" role="alert">
                        <h6 style="font-style: italic;">{{$customerInfo->comment}}</h6>

                    </div>
                    @endif
                </div>
            </li>

        </ul>


        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <div class="" style="font-size: 20px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </li>
            <li class="nav-item">
                @if(isset($customerInfo->status))
                <div class="" style="">
                    <p class="verified_text text-capitalize">&#x1f514; {{$customerInfo->status}} </p>
                </div>
                @endif
            </li>
            <li class="nav-item">
                <p class="nav_sign">
                    &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                </p>
            </li>
            @if (isset($customerInfo))
            <li class="nav-item dropdown">
                <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Profile_pic" class="top_nav_img dropdown-toggle" id="profile_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                <div class="dropdown-menu profile_dropdownMenu" aria-labelledby="profile_dropdownMenu">
                    <div class="container">
                        <div class="row" style="padding: 13px 0">
                            <div class="col-12 main-section text-center">

                                <div class="row user-detail">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" class="top_nav_img2 rounded-circle img-thumbnail">
                                        <h5>{{$customerInfo->first_name}} {{$customerInfo->last_name}}</h5>
                                        <p>{{$customerInfo->email}}</p>

                                        <a href="{{ url('home/profile')}}" class="btn btn-light profile_link btn-sm"><b>Manage Profile</b></a>
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
            @endif
        </ul>
    </nav>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="margin: auto !important ;">
                    <div class="card profile_content_form">
                        <div class="card-body profile_card_body ">
                            <form action="{{url('/update-customer/')}}" method="post" enctype="multipart/form-data" class="profile_form" id="profile_form">
                                @csrf
                                @method('PUT')
                                <div class="form-group d-flex justify-content-center align-content-center">
                                    <div class="" style="position: relative;">
                                <input id="cus__status" type="hidden" name="check_customer_status" value="{{ $customerInfo->status }}">
                                        @if (isset($customerInfo->profile_picture))
                                            <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Avatar" style="width:80px;border-radius: 20%;" />
                                        @else
                                            <img src="{{asset('/uploads/customer_pro_pic/default_customer.png')}}" alt="Avatar" style="width:80px;border-radius: 20%;" />
                                        @endif
                                        <span style="position: absolute;bottom: 0;right: 0;">
                                            <span class="btn btn-primary btn-file " id="pro_pic">
                                                Browse...<input type="file" name="profile_picture" id="profile_picture" 
                                                onClick="(function(){
                                                   let t = document.getElementById('cus__status').value;
                                                })();return confirm('Are you sure? Your status will changed to pending as image and address changes will required verification from admin.');" 

                                                accept="image/*">
                                            </span>
                                            <i class="fas fa-edit fa-edit" id="propic_edit"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="staticEmail">
                                        <h5>Personal Details</h5>
                                    </label>
                                    <div class="col-sm-4 right_align"> Edit
                                        <i class="fas fa-edit fa-edit click_shake" id="edit"

                                        onClick="(function(){
                                            let t = document.getElementById('cus__status').value;
                                         })();return confirm('Are you sure? Your status will changed to pending as image and address changes will required verification from admin.');" 

                                        ></i>
                                    </div>
                                </div><br>
                                @if(session('update-notify'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Great! </strong>{{session('update-notify')}}
                                </div>
                                @endif
                                @if(session('nid-error'))
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{session('nid-error')}}
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="name" class="form-control info_edit_disabled" id="first_name" name="first_name" value="{{$customerInfo->first_name}}">
                                    <p style="color: darkred;font-size: smaller">[NB: Click on edit button to edit]</p>
                                </div><br>

                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="name" class="form-control info_edit_disabled" id="last_name" name="last_name" value="{{$customerInfo->last_name}}">
                                    <p style="color: darkred;font-size: smaller">[NB: Click on edit button to edit]</p>
                                </div><br>

                                <div class="form-group">
                                    <label for="email">Email </label>
                                    <input type="email" class="form-control disabled_with_background" id="email" name="email" value="{{$customerInfo->email}}">
                                    <p style="color: darkred;font-size: smaller">[NB: Customer email Can't change]</p>
                                </div><br>
                                {{-- nid file---------------------------------------  --}}
                                @if($customerInfo->nid != 'no_data')
                                <div>
                                    <div class="form-group">
                                        <label for="id_type">Proof of ID</label>
                                        <span class="small ml-auto" style="color: #213f7e;float: right;">[NB: Able to upload just for One time]</span>

                                        <select class="form-control info_edit_disabled disabled_with_background" name="id_type">
                                            <option selected disabled>{{$customerInfo->id_type}}</option>
                                            <option>Valid International Passport </option>
                                            <option>Driving Licence</option>
                                            <option>National Identity Card</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="display: flex;">
                                        <label class="upload-label progress_bar_file info_edit_disabled disabled_with_background ">
                                            <input type="file" class="nid_file" name="nid">
                                            <span class="upload-file-label ">Upload File</span>
                                            <h5 class="filename text-truncate">{{$customerInfo->nid}}</h5>
                                        </label>
                                    </div><br>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="id_type">Proof of ID</label>
                                    <span class="small ml-auto" style="color: #213f7e;float: right;">[NB: Able to upload just for One time]</span>
                                    <select class="form-control info_edit_disabled disabled_with_background" id="id_type" name="id_type">
                                        <option selected disabled>Choose ID type</option>
                                        <option>Valid International Passport </option>
                                        <option>Driving Licence</option>
                                        <option>National Identity Card</option>
                                    </select>
                                </div>
                                <div class="form-group" id="select_alert" style="display: flex;">
                                    <label class="upload-label progress_bar_file info_edit_disabled disabled_with_background id_type_mandatory" id="id_type_click">
                                        <input type="file" class="nid_file" name="nid">
                                        <span class="upload-file-label ">Upload File</span>
                                        <h5 class="filename text-truncate">No File choosen</h5>
                                    </label>
                                </div><br>
                                @endif

                                {{-- end-----------------------------------------------  --}}
                                {{-- Residential file--------------------------------------  --}}
                                @if($customerInfo->ra_file != 'no_data')
                                <div>
                                    <div class="form-group">
                                        <label for="ra_type">Proof of Residential Address</label>
                                        <span class="small ml-auto" style="color: #213f7e;float: right;">[NB: Able to upload just for One time]</span>
                                        <select class="form-control info_edit_disabled disabled_with_background"  name="ra_type">
                                            <option selected disabled>{{$customerInfo->ra_type}}</option>
                                            <option>Utility Bill (Gas, Electric or Water)</option>
                                            <option>Telephone bill (Mobile phone bills are not accepted)</option>
                                            <option>Insurance Letter (Motor, Home or Life)</option>
                                            <option>Mortgage Statement</option>
                                            <option>Council Tax Bill</option>
                                            <option>Bank/ Building Society Statement</option>
                                            <option>TV Licence</option>
                                            <option>HM Revenue and Customs Letter/Notice of Coding</option>
                                            <option>Letter from Benefits Agency</option>
                                            <option>Financial Statement (e.g Pension/ Endowment)</option>
                                            <option>Polling card</option>
                                        </select>
                                    </div>
                                    <div class="form-group"  style="display: flex;">
                                        <label class="upload-label_2 progress_bar_file_2 info_edit_disabled">
                                            <input type="file" class="residential_file" name="ra_file">
                                            <span class="upload-file-label ">Upload File</span>
                                            <h5 class="filename2 text-truncate">{{$customerInfo->ra_file}}</h5>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                @else
                                <div class="form-group">
                                    <label for="ra_type">Proof of Residential Address</label>
                                    <span class="small ml-auto" style="color: #213f7e;float: right;">[NB: Able to upload just for One time]</span>
                                    <select class="form-control info_edit_disabled disabled_with_background " name="ra_type" id="ra_type" >
                                        <option selected disabled>Choose document type</option>
                                        <option>Utility Bill (Gas, Electric or Water)</option>
                                        <option>Telephone bill (Mobile phone bills are not accepted)</option>
                                        <option>Insurance Letter (Motor, Home or Life)</option>
                                        <option>Mortgage Statement</option>
                                        <option>Council Tax Bill</option>
                                        <option>Bank/ Building Society Statement</option>
                                        <option>TV Licence</option>
                                        <option>HM Revenue and Customs Letter/Notice of Coding</option>
                                        <option>Letter from Benefits Agency</option>
                                        <option>Financial Statement (e.g Pension/ Endowment)</option>
                                        <option>Polling card</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display: flex;" id="select_alert2">
                                    <label class="upload-label_2 progress_bar_file_2 info_edit_disabled ra_type_mandatory" id="ra_type_click">
                                        <input type="file" class="residential_file" name="ra_file">
                                        <span class="upload-file-label ">Upload File</span>
                                        <h5 class="filename2 text-truncate">No File choosen</h5>
                                    </label>
                                </div><br>
                                @endif

                                {{-- end ---------------------------------------------  --}}
                                <label for="address">Address</label>
                                <div class="form-row">
                                    @if($customerInfo->house)
                                    <div class="form-group col-md-2">
                                        <label for="inputHouse">House</label>
                                        <input type="text" class="form-control info_edit_disabled" name="house" id="inputHouse" value="{{$customerInfo->house}}">
                                    </div>
                                    @else
                                    <div class="form-group col-md-2">
                                        <label for="inputHouse">House</label>
                                        <input type="text" class="form-control info_edit_disabled" name="house" id="inputHouse" placeholder="HN">
                                    </div>
                                    @endif
                                    @if($customerInfo->road)
                                    <div class="form-group col-md-5">
                                        <label for="inputRoad">Road</label>
                                        <input type="text" class="form-control info_edit_disabled" name="road" id="inputRoad" value="{{$customerInfo->road}}">
                                    </div>
                                    @else
                                    <div class="form-group col-md-5">
                                        <label for="inputRoad">Road</label>
                                        <input type="text" class="form-control info_edit_disabled" name="road" id="inputRoad" placeholder="Road">
                                    </div>
                                    @endif
                                    @if($customerInfo->city)
                                    <div class="form-group col-md-5">
                                        <label for="inputCity">City</label>
                                        <input type="text" class="form-control info_edit_disabled" name="city" id="inputCity" value="{{$customerInfo->city}}">
                                    </div>
                                    @else
                                    <div class="form-group col-md-5">
                                        <label for="inputCity">City</label>
                                        <input type="text" class="form-control info_edit_disabled" name="city" id="inputCity" placeholder="City">
                                    </div>
                                    @endif
                                    @if($customerInfo->zip)
                                    <div class="form-group col-md-6">
                                        <label for="inputZip">Zip Code</label>
                                        <input type="text" class="form-control info_edit_disabled" name="zip" id="inputZip" value="{{$customerInfo->zip}}">
                                    </div>
                                    @else
                                    <div class="form-group col-md-6">
                                        <label for="inputZip">Zip Code</label>
                                        <input type="text" class="form-control info_edit_disabled" name="zip" id="inputZip" placeholder="Zip">
                                    </div>
                                    @endif
                                    @if($customerInfo->country)
                                    <div class="form-group col-md-6">
                                        <label for="inputCountry">Country Name</label>
                                        <input type="text" class="form-control info_edit_disabled" name="country" id="inputCountry" value="{{$customerInfo->country}}">
                                    </div>
                                    @else
                                    <div class="form-group col-md-6">
                                        <label for="inputCountry">Country Name</label>
                                        <input type="text" class="form-control info_edit_disabled" name="country" id="inputCountry" placeholder="Country">
                                    </div>
                                    @endif
                                </div>

                                @if($customerInfo->phone)
                                <div class="form-group">
                                    <label for="number">Phone Number</label>
                                    <input type="text" class="form-control info_edit_disabled" id="number" name="phone" value="{{$customerInfo->phone}}">
                                </div><br>
                                @else
                                <div class="form-group">
                                    <label for="number">Phone Number</label>
                                    <input type="text" class="form-control info_edit_disabled" id="number" name="phone" placeholder="Phone Number">
                                </div><br>
                                @endif

                                <div class=" text-center">
                                    <button type="submit" class="btn btn-block btn-primary" style="background-color: #4195D1;">Save</button>
                                </div>
                            </form><br><br>
                            <br>
                            <form action="{{url('/change-password/')}}" method="post">
                                @csrf
                                @method('PUT')

                                <label for="password">Change Password:</label><br><br>
                                @if(session('pass-done-notify'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{session('pass-done-notify')}}
                                </div>
                                @endif
                                @if(session('error-message'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{session('error-message')}}
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="c_password">Old Password</label>
                                    <input type="password" class="form-control " name="old_password" id="old_password" placeholder="Old password">
                                </div><br>
                                <div class="form-group">
                                    <label for="c_password">New Password</label>
                                    <input type="password" class="form-control " name="new_password" id="new_password" placeholder="New password">
                                </div><br>
                                <div class="form-group">
                                    <label for="c_password">Confirm New Password</label>
                                    <input type="password" class="form-control " name="confirm_password" id="confirm_password" placeholder="Confirm New password">
                                </div><br>
                                <div class=" text-center">
                                    <button type="submit" class="btn btn-block btn-primary" style="background-color: #4195D1;">Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.login-card-body -->
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
