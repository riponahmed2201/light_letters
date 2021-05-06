<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Customer Web App</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css"> --}}
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{------------------------- my included ----------------------------------}}
    <!-------------bootstrap 4----------------------->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    {{--------------- js script ----------------------------}}
    {{-- for js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.ui.widget@1.10.3/jquery.ui.widget.js"></script>
    {{-- for bootstrap  --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    {{-- for search icon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    {{-- for check box icon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    {{-- for refresh icon --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- Montserrat front adding --}}
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    {{-- my own sheet --}}
    <link href="/css/mystyle.css" rel=" stylesheet">
    <link href="/css/mystyle_mobile.css" rel=" stylesheet">
    <style>

    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar bg-white elevation-4">
            <div class="logo_container container">


                <img src="{{asset("../img/Light Letters Logo-01.jpg")}}" alt="LOGO" class="mx-auto img-responsive  logo_decoration" id="bye" />
                {{-- <a href="#" id="bye" class="d-block navbar-brand logo_decoration">LOGO</a> --}}

            </div>
            <div class="sidebar">

                <nav class="mt-2 aside_nav" id="">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="{{isset($lastSlug) && $lastSlug=='home' ? 'reddi' : 'nav-item'}}">
                            <a href="{{ url('home')}}" class="nav-link">
                                Mailbox
                            </a>
                        </li>
                        {{-- <li class="{{isset($lastSlug) && $lastSlug=='profile' ? 'reddi' : 'nav-item'}}">
                        <a href="{{ url('home/profile')}}" class="nav-link">
                            Profile
                        </a>
                        </li>


                        <li class="nav-item">
                            <form action="{{url('/customer-logout')}}" method="post" class="nav-link nav_form">
                                @csrf
                                <button type="submit" class="btn btn-block">Logout</button>
                            </form>
                        </li> --}}
                    </ul>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <div class="nav_normal_item">
                <a href="{{ url('home/policy')}}" style="background-color: unset;color: gray !important;">
                    <small> Privacy Policy</small>
                </a>
                <p><a href="{{ url('home/faq')}}" style="background-color: unset;color: gray !important;" class="small"> FAQ</a></p>
            </div>

            <!-- /.sidebar -->
        </aside>




        @yield('content')

    </div>
    <!-- ./wrapper -->


    <!-- jQuery -->
    {{-- <script src="../plugins/jquery/jquery.min.js"></script>  --}}
    <!-- jQuery UI 1.11.4 -->
    {{-- <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>  --}}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    {{-- <script src="../plugins/summernote/summernote-bs4.min.js"></script> --}}
    <!-- overlayScrollbars -->
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!------ include summernote bootstrap +js------------------------------>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(".nid_file").on('change', function(e) {
            // alert("file is selected");
            //get file name
            var filename = e.target.files[0].name;
            $(".filename").text(filename);
            /////end
            $(".upload-label").addClass("progress-bar");
            //it;s a static part not a daynamic
            setTimeout(function() {
                $(".upload-label").removeClass("progress-bar");
                $(".upload-label").addClass("upload-complete");
            }, 5000);
            //11000=11seconds
        });
        $(".residential_file").on('change', function(e) {
            var filename2 = e.target.files[0].name;
            $(".filename2").text(filename2);
            /////end
            // sudo element works
            $(".upload-label_2").addClass("progress-bar_2");
            $(".upload-file-label").css('width', '100%');
            //it;s a static part not a daynamic
            setTimeout(function() {
                $(".upload-label_2").removeClass("progress-bar_2");
                $(".upload-file-label").css('width', 'unset');
                $(".upload-label_2").addClass("upload-complete_2");
            }, 5000);
            //11000=11seconds
        });
        jQuery(function($) {
            $("#search").on("keyup", function() {
                // var value = $(this).val().toLowerCase();
                // $(".my_msg_table tr").filter(function() {
                //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                // });

                var value = $(this).val().toLowerCase();
                if ($.trim(value) != "") {
                    $(".my_msg_table").attr("id", "newId");

                } else if ($.trim(value) == "") {
                    $(".my_msg_table").attr("id", "data");

                }
                $(".my_msg_table tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });





            });
            // $('#data tbody tr').hide();

            // $("#msg_box_popup").find(".file_chosen_parent").hide();
            // $(".file_name").on("keyup", function() {
            //     var spanContent = document.getElementsByClassName("file_name")[0];
            // if (spanContent.innerHTML == "") {
            //     $("#msg_box_popup").find(".file_chosen_parent").hide();
            // } else if (spanContent.innerHTML != "") {
            //     $("#msg_box_popup").find(".file_chosen_parent").show();
            // }else if (spanContent.innerHTML !== "") {

            //     $("#msg_box_popup").find(".file_chosen_parent").show();
            // }
            // });
        });
        $('#reply_box_summernote').summernote({
            placeholder: 'Details....'
            , tabsize: 2
            , height: 140
            , toolbar: [
                ['style', ['style']]
                , ['font', ['bold', 'underline', 'clear']]
                , ['color', ['color']]
                , ['para', ['ul', 'ol', 'paragraph']]
                , ['table', ['table']]
                // , ['view', ['fullscreen', 'codeview', 'help']]

            ],
            //Define the callback
            // callbacks: {
            //     onFileUpload: function(file) {
            //         //Your own code goes here
            //         //console.log("file", file[0]);

            //         for (let key in file) {
            //             if (file[key].name && file[key].size) {
            //                 var HTMLstring = `<div><span><a href="#">
            //                     ${ file[key].name }</a>&nbsp;</span><span style="color:red">Size: ${
            //             file[key].size / 1000
            //           } KB</span></div>`;
            //                 $("#reply_box_summernote").summernote("pasteHTML", HTMLstring);
            //             }
            //         }
            //     }
            // , },
        });
        // summernote upload button

        const actualBtn = document.getElementById('actual-btn');

        const fileChosen = document.getElementById('file-chosen');
        if (actualBtn) {
            actualBtn.addEventListener('change', function() {
                fileChosen.textContent = this.files[0].name;

            });
        }

    </script>
    {{-- --------------- my js file link ----------------------------------- --}}
    <script src="{{url('assets/js/custom.js')}}"></script>
    <script src="{{url('assets/js/languageTranslate.js')}}"></script>

</body>

</html>
