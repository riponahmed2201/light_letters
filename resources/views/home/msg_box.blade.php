@extends('layouts.app')
@section('content')
    <div class="content-wrapper my_content_wrapper" id="content">
        <nav class="main-header navbar navbar-expand navbar-white text-dark ml-md-0 ">
            <!-- Left navbar links -->
            <ul class="navbar-nav mr-auto">
                {{-- left hidden botton for aside manu  --}}
                <li class="nav-item aside_pushmenu_bar">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- --------  --}}

            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <p class="nav_sign" >
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
                @if(isset($customerInfo))
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

                                                <a  href="{{ url('home/profile')}}" class="btn btn-light profile_link btn-sm"><b>Manage Profile</b></a>
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
            <div class="row">
                <div class="col-md-12" style="padding: 0 !important;">
                    <div class="card msg_box_main" style="width: 100%;padding: 0 40px;;padding-top: 0;">
                        <div class="card-body ">

                            {{-- ------------ -------------- --}}

                            <div class="row msg_box msg_view">
                                {{-- 1st row >main msg view->subject line--}}
                                <div class="col-sm-12 row msg_box_subject">
                                    <h4>{{ $subject = isset($mailDetails->subject) ? $mailDetails->subject : '' }}</h4>&nbsp&nbsp&nbsp
                                    @if($mailDetails->quick_reply && $mailDetails->reply_status != null)
                                        <div class="quick_reply">
                                            {{-- <span class="badge badge-secondary  ">Quick Reply</span> --}}
                                            <span class="badge badge-secondary  ">Reply Required</span>
                                        </div>
                                    @endif
                                </div>
                                {{-- 2nd row >main msg body---------------------------------}}
                                <div class="row" style="width: 100%">
                                    <div class=" col-sm-1 col-md-1 mr-1" style="max-width: 5.333333% !important;">
                                        <img src="{{asset('/uploads/client_pro_pic/'.$clientInfo->profile_picture)}}" class="s_r_both_pic" alt="Avatar" />
                                    </div>
                                    <div class="col-sm-10 msg_content" >

                                        <div class="msg_header">
                                            <div class="row w-100">
                                                <div class="col-md-12 col-sm-12 m-0">
                                                    <h5 class=""><b>{{$clientInfo->name}}</b>
                                                    </h5>
{{--                                                    <span class="msg_reminder">--}}
                                                        @if($reminder)
                                                            @foreach($reminder as $rem)
                                                                <span class="msg_reminder_span mb-1 mb-md-0">&#x1f514; Reminder : {{(Carbon\Carbon::parse($rem)->format('d M Y') )}} </span>
                                                            @endforeach
                                                        @endif

                                                        @if (isset($mailDetails->deadline))
                                                            <span class="msg_reminder_span mb-1 mb-md-0">&#x1f514; Deadline : {{(Carbon\Carbon::parse($mailDetails->deadline)->format('d M Y') )}} </span>
                                                        @endif
                                                        {{-- <span class="msg_reminder_span">&#x1f514; Remainder : 2-2-2020 </span> --}}
{{--                                            </span>--}}
                                                    @if ($mailDetails->tag)
                                                        @php
                                                        $tagData = json_decode($mailDetails->tag);
                                                        @endphp
                                                        {{-- <span class="msg_reminder_span mb-1 mb-md-0"
                                                              style="background-color: #f5a351;color:black;">&#x1F4CC;
                                                             {{ $mailDetails->tag }}
                                                        </span> --}}
                                                    <span class="msg_reminder_span mb-1 mb-md-0"
                                                        style="background-color: white;color:black;">&#x1F4CC;
                                                        @if (isset($tagData))
                                                            @foreach ($tagData as  $tag)
                                                                {{-- <span class="badge badge-pill p-2 h4 text-white" style="background-color:#213f7e;">{{ $tag }}</span> --}}
                                                                <button class="btn btn-sm text-white font-weight-bold" style="background-color:#213f7e; border-radius: 25px">  {{ $tag }}</button>
                                                            @endforeach
                                                        @endif
                                                    </span> 
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail" style="">
                                            <p>from : {{$mailDetails->sender}}</p>
                                            {{-- <p>Cc : {{$mailDetails->cc}}</p> --}}
                                            <div class="btn-group mail_cc">
                                                <button type="button" class="btn text-dark small_text">Cc : {{$cc ? $cc[0] : ''}}</button>&nbsp
                                                <button type="button" class="btn  dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                                </button>
                                                <div class="dropdown-menu small_text ">
                                                    @if($cc)
                                                        @foreach($cc as $ccList)
                                                            <a class="dropdown-item disabled bold " href="#">{{($ccList)}}</a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!--  Here created at date  -->
                                        <div class="mt-3">
                                            {{ Carbon\Carbon::parse($mailDetails->created_at)->format('d M Y') }}
                                        </div>

                                        <div class="mt-4">
                                            <p> {{ $customerDetailsInfo->first_name }} {{ $customerDetailsInfo->last_name }} </p>
                                            <p style="height:6px;"> {{ $customerDetailsInfo->road }}, {{ $customerDetailsInfo->house }}</p>
                                            <p style="height:6px;">  {{ $customerDetailsInfo->city }} {{ $customerDetailsInfo->zip }} </p>
                                            <p> {{ $customerDetailsInfo->country }} </p> <br>
                                        </div>

                                        {{-- <div class="quick_reply">--}}
                                        {{-- <span class="badge badge-secondary ">quick reply</span>--}}
                                        {{-- </div>--}}
                                        <div class="msg_view_body" style=" ">
                                            <div class="msg_body msg" style=" ">
                                                {{--                                        {{strip_tags($mailDetails->mail_body)}}--}}
                                                {!!($mailDetails->mail_body)!!}
                                            </div>
                                            {{-- --------File View Start---------------------------------- --}}
                                            <div class="row">
                                                @if($mailDetails->mail_file)
                                                    <div class="col-md-4 shadow uploaded_file">
                                                        <div class="uploaded_file_p1 text-truncate">
                                                            <h6><strong>File Name: </strong>{{$mailDetails->mail_file}}
                                                            </h6>
                                                            <span style="font-size: .6rem"><strong>File Size: {{$fileSize}} KB</strong></span>
                                                        </div>
                                                        <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/file-down/'.$mailDetails->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                        </div>
                                                        {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-md-1 msg_time" style="width:10%">
                                        {{-- {{ Carbon\Carbon::parse($mailDetails->created_at)->format('d M Y') }} --}}
                                        <a href="{{url('/remove-customer-mail/'.$mailDetails->id)}}">
                                    <span id="" class="msg_view_trash click_shake  " style="display: none">
                                        <i class="far fa fa-trash fa-lg"></i>
                                    </span>
                                        </a>
                                    </div>
                                </div>


                            </div>
                            {{-----------------------/main msg end/-------------------------}}

                            {{-------------3rd row>msg reply -----------------------}}
                            <div class="row ">
                                <div class="col-sm-12">

                                    @if ($replyMail->count() <= 2) @foreach($replyMail as $reply) <div class="row chatting_lines">
                                    
                                        <hr class="hr2">
                                        {{--- --------  msg_reply 1st row  -- -------- --------}}
                                        @if($reply->sender == $clientInfo->email)
                                            <div class="row chatting_lines_sender" style="width: 100%;">
                                                <div class="col-sm-1 col-md-1 chatting_part_img">
                                                    <img class="s_r_both_pic" src="{{asset('/uploads/client_pro_pic/'.$clientInfo->profile_picture)}}" alt="Avatar" />
                                                </div>
                                                <div class="col-sm-10 chatting_part_body" style="">
                                                    <strong>{{$clientInfo->name}} </strong>
                                                    <div> {!!($reply->mail_body)!!}</div>
                                                    {{-- File With Reply Mail--}}
                                                    <div class="row">
                                                        @if($reply->mail_file)
                                                            <div class="col-md-4 shadow uploaded_file">
                                                                <div class="uploaded_file_p1  text-truncate">
                                                                    <h6><strong>File Name: </strong>{{($reply->mail_file)}}
                                                                    </h6>

                                                                    {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                </div>
                                                                <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                </div>
                                                                {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 col-md-1 msg_time">
                                                    {{ Carbon\Carbon::parse($reply->created_at)->format('d M Y') }}
                                                </div>
                                                <a href="{{url('/remove-customer-reply/'.$reply->id)}}">
                                            <span id="" class="msg_view_trash click_shake" style="display: none">
                                                <i class="far fa fa-trash fa-lg"></i>
                                            </span>
                                                </a>

                                            </div>
                                        @endif
                                        {{-- ------ msg_reply 2nd row  -- --------}}
                                        @if($reply->sender == $customerInfo->email)
                                            <div class="row chatting_lines_receiver" style="width: 100%;">
                                                <div class="col-sm-1 col-md-1 chatting_part_img">
                                                    <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Avatar" class="s_r_both_pic" />
                                                </div>
                                                <div class="col-sm-10 chatting_part_body">
                                                    <strong>{{$customerInfo->first_name}} {{$customerInfo->last_name}} </strong>
                                                    <div> {!!($reply->mail_body)!!}</div>

                                                    <div class="row">
                                                        @if($reply->mail_file)
                                                            <div class="col-md-4 shadow uploaded_file">
                                                                <div class="uploaded_file_p1  text-truncate">
                                                                    <h6><strong>File Name: </strong>{{($reply->mail_file)}}
                                                                    </h6>

                                                                    {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                </div>
                                                                <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                </div>
                                                                {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col-sm-1 col-md-1 msg_time">
                                                    {{ Carbon\Carbon::parse($reply->created_at)->format('d M Y') }}
                                                </div>
                                                <a href="{{url('/remove-customer-reply/'.$reply->id)}}">
                                            <span id="" class="msg_view_trash click_shake" style="display: none">
                                                <i class="far fa fa-trash fa-lg"></i>
                                            </span>
                                                </a>

                                            </div>
                                        @endif
                                    </div>
                                    @endforeach

                                    @elseif($replyMail->count() > 2)
                                        <div class="msg_collapse">
                                            <a class="card-link collapse_icon " data-toggle="collapse" data-placement="right" title="view all reply" href="#collapseOne">
                                                <i class="fas fa-angle-double-down"></i>
                                            </a>
                                            <div id="collapseOne" class="collapse my-4" data-parent=".msg_collapse">
                                                @foreach($replyMail as $reply)


                                                    <div class="row chatting_lines">
                                                        <hr class="hr2">
                                                        {{--- --------  msg_reply 1st row  -- -------- --------}}
                                                        @if($reply->sender == $clientInfo->email)
                                                            <div class="row chatting_lines_sender" style="width: 100%;">
                                                                <div class="col-sm-1 col-md-1 chatting_part_img">
                                                                    <img class="s_r_both_pic" src="{{asset('/uploads/client_pro_pic/'.$clientInfo->profile_picture)}}" alt="Avatar" />
                                                                </div>
                                                                <div class="col-sm-10 chatting_part_body" style="">
                                                                    <strong>{{$clientInfo->name}} </strong>
                                                                    <div> {!!($reply->mail_body)!!}</div>
                                                                    {{-- File With Reply Mail--}}
                                                                    <div class="row">
                                                                        @if($reply->mail_file)
                                                                            <div class="col-md-4 shadow uploaded_file">
                                                                                <div class="uploaded_file_p1  text-truncate">
                                                                                    <h6><strong>File Name: </strong>{{($reply->mail_file)}}
                                                                                    </h6>

                                                                                    {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                                </div>
                                                                                <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                                </div>
                                                                                {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1  col-md-1 msg_time">
                                                                    {{ Carbon\Carbon::parse($reply->created_at)->format('d M Y') }}
                                                                </div>
                                                                <a href="{{url('/remove-customer-reply/'.$reply->id)}}">
                                                <span id="" class="msg_view_trash click_shake" style="display: none">
                                                    <i class="far fa fa-trash fa-lg"></i>
                                                </span>
                                                                </a>

                                                            </div>
                                                        @endif
                                                        {{-- ------ msg_reply 2nd row  -- --------}}
                                                        @if($reply->sender == $customerInfo->email)
                                                            <div class="row chatting_lines_receiver" style="width: 100%;">
                                                                <div class="col-sm-1 col-md-1 chatting_part_img">
                                                                    <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Avatar" class="s_r_both_pic" />
                                                                </div>
                                                                <div class="col-sm-10 chatting_part_body">
                                                                    <strong>{{$customerInfo->first_name}} {{$customerInfo->last_name}} </strong>
                                                                    <div> {!!($reply->mail_body)!!}</div>

                                                                    <div class="row">
                                                                        @if($reply->mail_file)
                                                                            <div class="col-md-4 shadow uploaded_file">
                                                                                <div class="uploaded_file_p1  text-truncate">
                                                                                    <h6><strong>File Name: </strong>{{($reply->mail_file)}}
                                                                                    </h6>

                                                                                    {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                                </div>
                                                                                <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                                </div>
                                                                                {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-1  col-md-1 msg_time">
                                                                    {{ Carbon\Carbon::parse($reply->created_at)->format('d M Y') }}
                                                                </div>
                                                                <a href="{{url('/remove-customer-reply/'.$reply->id)}}">
                                                <span id="" class="msg_view_trash click_shake" style="display: none">
                                                    <i class="far fa fa-trash fa-lg"></i>
                                                </span>
                                                                </a>

                                                            </div>
                                                        @endif
                                                    </div>

                                                @endforeach
                                            </div>

                                        </div>
                                        {{-- -------last_two_reply------  --}}
                                        <div class="last_two_reply mt-md-5 mt-sm-1">
                                            @foreach($reversed_latestReply as $last_two_reply)

                                                <div class="row chatting_lines">
                                                    <hr class="hr2">
                                                    {{--- --------  msg_reply 1st row  -- -------- --------}}
                                                    @if($last_two_reply->sender == $clientInfo->email)
                                                        <div class="row chatting_lines_sender" style="width: 100%;">
                                                            <div class="col-sm-1 col-md-1 chatting_part_img">
                                                                <img class="s_r_both_pic" src="{{asset('/uploads/client_pro_pic/'.$clientInfo->profile_picture)}}" alt="Avatar" />
                                                            </div>
                                                            <div class="col-sm-10 chatting_part_body" style="">
                                                                <strong>{{$clientInfo->name}} </strong>
                                                                <div> {!!($last_two_reply->mail_body)!!}</div>
                                                                {{-- File With Reply Mail--}}
                                                                <div class="row">
                                                                    @if($last_two_reply->mail_file)
                                                                        <div class="col-md-4 shadow uploaded_file">
                                                                            <div class="uploaded_file_p1  text-truncate">
                                                                                <h6><strong>File Name: </strong>{{($last_two_reply->mail_file)}}
                                                                                </h6>

                                                                                {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                            </div>
                                                                            <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$last_two_reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                            </div>
                                                                            {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1 col-md-1 msg_time">
                                                                {{ Carbon\Carbon::parse($last_two_reply->created_at)->format('d M Y') }}
                                                            </div>
                                                            <a href="{{url('/remove-customer-reply/'.$last_two_reply->id)}}">
                                            <span id="" class="msg_view_trash click_shake" style="display: none">
                                                <i class="far fa fa-trash fa-lg"></i>
                                            </span>
                                                            </a>

                                                        </div>
                                                    @endif
                                                    {{-- ------ msg_reply 2nd row  -- --------}}
                                                    @if($last_two_reply->sender == $customerInfo->email)
                                                        <div class="row chatting_lines_receiver" style="width: 100%;">
                                                            <div class="col-sm-1 col-md-1 chatting_part_img">
                                                                <img src="{{asset('/uploads/customer_pro_pic/'.$customerInfo->profile_picture)}}" alt="Avatar" class="s_r_both_pic" />
                                                            </div>
                                                            <div class="col-sm-10 chatting_part_body">
                                                                <strong>{{$customerInfo->first_name}} {{$customerInfo->last_name}} </strong>
                                                                <div> {!!($last_two_reply->mail_body)!!}</div>

                                                                <div class="row">
                                                                    @if($last_two_reply->mail_file)
                                                                        <div class="col-md-4 shadow uploaded_file">
                                                                            <div class="uploaded_file_p1  text-truncate">
                                                                                <h6><strong>File Name: </strong>{{($last_two_reply->mail_file)}}
                                                                                </h6>

                                                                                {{-- <h6><strong>File Size: </strong> {{replyFileSize($reply->id)}} KB</h6>--}}
                                                                            </div>
                                                                            <div class="uploaded_file_p2 hover_shake"> <span><a href="{{url('/reply-file-down/'.$last_two_reply->mail_file)}}"><i class="fa fa-download"></i></a></span>
                                                                            </div>
                                                                            {{-- <embed src="{{asset('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file)}}"> --}}

                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-1 col-md-1 msg_time">
                                                                {{ Carbon\Carbon::parse($last_two_reply->created_at)->format('d M Y') }}
                                                            </div>
                                                            <a href="{{url('/remove-customer-reply/'.$last_two_reply->id)}}">
                                            <span id="" class="msg_view_trash click_shake  " style="display: none">
                                                <i class="far fa fa-trash fa-lg"></i>
                                            </span>
                                                            </a>

                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- --------------  --}}

                                    @endif





                                </div>
                            </div>

                            {{------------//-------------------}}
                            {{-------------4rth row-> bubboles ----------------------}}
                            <div class="row mt-md-5">
                                <div class="col-sm-12 quick_reply_lines_parent ">
                                    {{-- bubboles --}}
                                    <div class="quick_reply_lines" id="msg_box_popup_btn">
                                        @if($quickReply && $mailDetails->reply_status != null)
                                            @foreach($quickReply as $rep)
                                                <span class="hi hover_shake" id="hi">
                                                {{ $rep}}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <br>

                                </div>
                            </div>
                            {{-------------//----------------------}}
                            {{-- 5th row >popup modal ----------------------------------------}}
                            <div class="row ">
                                <div class="col-sm-12 msg_box_popup_parent">
                                    {{-------------------------popup modal ------}}
                                    <div class="msg_box_popup display_none" id="msg_box_popup" style="">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ url('/reply-mail-client') }} " method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="input-group">
                                                        <label class="popup_reply_box_to" for="reply_box_to" style="padding-top: 8px;">To:</label>
                                                        <input type="hidden" class="form-control" name="direct_mail_id" value="{{$mailDetails->id}}">


                                                        <input type="text" style="border-top-left-radius: .25rem !important;
                                                    border-bottom-left-radius: .25rem !important;" class="form-control reply_box_to" id="reply_box_to" value="{{ $mailDetails->sender }}" aria-label="To" aria-describedby="basic-addon2" disabled>

                                                    </div>
                                                    {{-- <input type="file" class="form-control" name="mail_file"> --}}

                                                    <textarea class="reply_box_summernote" name="mail_body" id="reply_box_summernote" style="width:20%;" placeholder="Details"></textarea>

                                                    <div class="input-group extra_note_toolbar ">
                                                        <!-- actual upload which is hidden -->
                                                        <input type="file" name="mail_file" id="actual-btn" hidden />
                                                        <!-- our custom upload button -->
                                                        <label class="label_class" for="actual-btn"><i class="" for=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="14px" height="14px">
                                                                    <path d="M 16 3.59375 L 15.28125 4.28125 L 8.28125 11.28125 L 9.71875 12.71875 L 15 7.4375 L 15 24 L 17 24 L 17 7.4375 L 22.28125 12.71875 L 23.71875 11.28125 L 16.71875 4.28125 L 16 3.59375 z M 7 26 L 7 28 L 25 28 L 25 26 L 7 26 z" style="fill:none;stroke:#111111;stroke-width:3;stroke-linecap:round;"></path>
                                                                </svg></i></label>

                                                        <!-- name of file chosen -->
                                                        <span id="file-chosen">...</span>
                                                    </div>

                                                    <div class="popup_bottom">
                                                        <button type="submit" class="form-control btn btn-primary popup_submit">Send </button>
                                                        <i class="far fa fa-trash fa-lg popup_close" id="popup_close" style="float: right"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-------------//---------}}
                                    @if($mailDetails->reply_status)
                                        <div class="msg_box_popup_btn" id="msg_box_popup_btn">
                                            <a class="btn btn-info hover_shake" style="border-radius: 0px !important;background-color: #213f7e; color: white !important; width: 178px;text-align: center;">
                                                REPLY
                                            </a>
                                        </div>
                                    @endif

                                    <br>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;</p><br><br>

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
