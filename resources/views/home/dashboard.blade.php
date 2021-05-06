@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper my_content_wrapper" id="content">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white text-dark ml-md-0 ">
        <!-- Left navbar links -->
        <ul class="navbar-nav mr-auto myNavUl">
            {{-- left hidden botton for aside manu  --}}
            <li class="nav-item aside_pushmenu_bar">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- --------  --}}
            <form class="form-inline mr-auto navform " method="get" style="width: 550px">

                <div class="input-group search_form input-group-sm">
                    <input type="text" placeholder="Type here to search mail" name="search" id="search" class="form-control form-control-navbar" style="background-color: #f2f4f6;
                    border: 0;font-family:Arial, FontAwesome;height: 2.3rem;border-radius: 5px !important;" />
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="pl-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input large_checkbox particular_msglist_check" type="checkbox" name="checkbox" id="quick_reply_check" value="option1">
                    <label class="form-check-label bold " for="inlineCheckbox1">Quick Reply</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input large_checkbox particular_msglist_check" type="checkbox" name="checkbox" id="no_reply_check" value="option2">
                    <label class="form-check-label bold" for="inlineCheckbox2">No Reply</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input large_checkbox particular_msglist_check" type="checkbox" name="checkbox" id="reminder_check" value="option3">
                    <label class="form-check-label bold" for="inlineCheckbox3">Remainder</label>
                </div>
            </div>
        </ul>


        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if(isset($customerInfo->status))
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
            <li class="d-flex mr-2">
                <div id="google_translate_element">
                    <button class="btn globeIcon" type="submit" >
                        <i class="fas fa-globe"></i>
                    </button>
                </div>
                <div class="display_none" style="margin: 0 8px; margin-top:  5px;" id="crossIcon">
                    <i class="fas fa-lg fa-times"></i>
                </div>

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
                                            <h5 class="bold">{{$customerInfo->first_name}} {{$customerInfo->last_name}}</h5>
                                            <p class="small">{{$customerInfo->email}}</p>

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
    <!-- /.navbar -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-lg-12 col-sm-12 col-md-12 p-0">
                    <div class="card dashboard_msg_list my_card ususal_table_data">
                        <div class="msg_card_header">
                            {{-- ---------------------Delete notify----------------------}}
                            <div class="card-tools card_tools">
                                <input type="checkbox" class="msg_mark" id="msg_mark">
                                {{-- <i class="material-icons">&#xe5d5;</i> --}}
                                <span class="refresh"><i class="material-icons" style="line-height: unset;">refresh</i></span>
                                <a href="{{url('/remove-all-mail/'.$customerInfo->id)}}">
                                    <i class="far fa fa-trash fa-lg click_shake msg_trash display_none"></i>
                                </a>
                            </div>

                            <div class="card-tools ml-auto">
                                <div class="pagination">

                                    <a href="#" class="my_recent_page">1</a>
                                    <a href="#">of</a>
                                    <a href="#" class="my_ceil_totalpage">1</a>
                                </div>

                                <div class="pagination pagination_symbol">
                                    <div class="pagination_symbol_hover"> <a href="#" id="prev" class="">❮</a> </div>
                                    <div class="pagination_symbol_hover"> <a href="#" id="next">❯</a></div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        @if($directMailCount == 0)
                        <div class="alert alert-info" style="text-align: center" role="alert">
                            <strong>Dear customer, your mailbox is empty.</strong>
                        </div>
                        @endif
                        @if(session('mail-delete-notify'))
                        <div class="alert alert-success alert-dismissible" style="text-align: center" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{session('mail-delete-notify')}}</strong>
                        </div>
                        @endif
                        <div class="cart-body panel-body inbox position_relative">
                            <div class="col-12 position_absolute">
                                {{-- <tr id="quick_reply_table_data" class="display_none">  --}}
                                <table class="table borderless no-cellpadding table-sm my_msg_table" id="data" style="display:table">
                                    {{-- <tr> <td>Row 1</td></tr> --}}
                                    {{-- hide msg tr ----------------------------------------}}
                                    @foreach($allDirectMail as $mail)
                                    <tr id="me">
                                        {{-- <tr id="me"  @if($mail->quick_reply)> --}}
                                        <td style="white-space:nowrap;">
                                            <div class="position_relative per_msg_perent">
                                                <input type="checkbox" class="checkbox" name="check-1" value="check-1" id="check-1" checked>
                                                @if($mail->hide_status === null)
                                                    <div @if($mail->read_status === null) class="row msg_box unread_msg h6" style="font-weight: bolder;"  @else class="row msg_box read_msg" @endif onclick="window.location.href='/msg_box/'+{{$mail->id}}">
                                                        <div class="col-md-1 col-sm-1 my_msg_table_img">
                                                            <img src="{{asset('/uploads/client_pro_pic/'.$mail->profile_picture)}}" alt="Avatar" style="width:40px;border-radius: 30%;" ; />
                                                        </div>
                                                        <div class="col-sm-9 col-md-9 dashboard_msg_list_body">
                                                            <p style="display:none">
                                                                {{$mail->receiver}}
                                                                {{$mail->type}}
                                                                {{$mail->tag}}
                                                                {{$mail->group}}
                                                                {{$mail->sender}}
                                                                <span class="hidden_msg_quick_reply">{{$mail->quick_reply}}</span>
                                                                <span class="hidden_msg_remainder">{{$mail->remainder}}</span>
                                                                <span class="hidden_msg_reply_status">{{$mail->reply_status}}</span>
                                                            </p>
                                                            <p class="msg_sender">{{$mail->name}}
                                                             
                                                                @if($mail->tag)
                                                                    @php
                                                                    $tagData = json_decode($mail->tag);
                                                                    // dd($tagData);
                                                                    @endphp
                                                                    <span class="badge  directmail_tagg" style="color:black;">&#x1F4CC;
                                                                       @if (isset($tagData))
                                                                            @foreach ($tagData as  $tag)
                                                                                {{-- <span class="badge badge-pill p-2 h4 text-white" style="background-color:#203d79;">{{ $tag }}</span> --}}
                                                                                <button class="btn btn-sm text-white font-weight-bold" style="background-color:#213f7e; border-radius: 25px">  {{ $tag }}</button>
                                                                            @endforeach
                                                                        @endif
                                                                    </span>
                                                                    {{-- <span class="badge  directmail_tagg" style="background-color: #FFEA00;color:black;">&#x1F4CC; {{$mail->tag}}</span> --}}
                                                                @endif
                                                                @if($mail->remainder)
                                                                    <span class="badge  directmail_tagg" style="background-color: #FFCAAD;color:black;">&#x1f514; Reminder</span>
                                                                @endif
                                                                @if($mail->quick_reply)
                                                                    <span class="badge  directmail_tagg" style="background-color: #FFCAAD;color:black;">&#x1f514; Quick Reply</span>
                                                                @endif
                                                                @if($mail->deadline)
                                                                    <span class="badge  directmail_tagg" style="background-color: #FFCAAD;color:black;">&#x1f514; Deadline</span>
                                                                @endif
                                                            </p>

                                                        @if ($mail->read_status === null)
                                                            <p class="msg_subjct bold hide_line float-left">{{$mail->subject}} - &nbsp;</p>
                                                            <p class="float-left hide_line">{{strip_tags($mail->mail_body)}}</p>
                                                        </div>
                                                        <div class="col-sm-2 col-md-2 right_align inbox_right_col">
                                                            <span class="date_hide"> {{ Carbon\Carbon::parse($mail->created_at)->format('d M Y') }}</span>
                                                        </div>
                                                        @else
                                                            <p class="msg_subjct bold hide_line float-left" style="font-weight: normal">{{$mail->subject}} - &nbsp;</p>
                                                                <p class="float-left hide_line" style="font-weight: normal">{{strip_tags($mail->mail_body)}}</p>
                                                            </div>
                                                            <div class="col-sm-2 col-md-2 right_align inbox_right_col" style="font-weight: normal">
                                                                <span class="date_hide"> {{ Carbon\Carbon::parse($mail->created_at)->format('d M Y') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div @if($mail->read_status === null) class="row msg_box unread_msg" @else class="row msg_box read_msg" @endif onclick="window.location.href='/msg_box/'+{{$mail->id}}">
                                                        <div class="col-sm-1 col-md-1 my_msg_table_img">

                                                            <img src="{{asset('/uploads/client_pro_pic/'.$mail->profile_picture)}}" alt="Avatar" style="width:40px;border-radius: 30%;" ; />
                                                        </div>
                                                        <div class="col-sm-9 col-md-9 dashboard_msg_list_body hidden_mail_info">
                                                            <p style="display: none">
                                                                {{$mail->receiver}}
                                                                {{$mail->type}}
                                                                {{$mail->tag}}
                                                                {{$mail->group}}
                                                                {{$mail->sender}}
                                                                <span class="hidden_msg_quick_reply">{{$mail->quick_reply}}</span>
                                                                <span class="hidden_msg_remainder">{{$mail->remainder}}</span>
                                                                <span class="hidden_msg_reply_status">{{$mail->reply_status}}</span>
                                                            </p>
                                                            @if($mail->read_status === null)
                                                                <p><strong>1 new mail received!</strong></p>
                                                            @else
                                                                <p><strong>This mail info is hidden!</strong></p>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2 col-sm-2 right_align inbox_right_col">
                                                            <span class="date_hide"> {{ Carbon\Carbon::parse($mail->created_at)->format('d M Y') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <a href="{{url('/remove-customer-mail/'.$mail->id)}}">
                                                    <span id="hover_msg_trash" class="hover_msg_trash click_shake" style="display: none">
                                                        <i class="far fa fa-trash fa-lg"></i>
                                                    </span>
                                                </a>
                                                <hr style="">
                                            </div>
                                        </td>
                                        {{-- </tr @endif> --}}
                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- ./col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection
