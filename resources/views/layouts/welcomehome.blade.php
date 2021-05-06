<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Bootstrap start CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!----------mystyle sheet------------->
    <link href="/css/mywelcomestyle.css" rel=" stylesheet">
    {{-- Montserrat front adding --}}
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
   
</head>
<body>
    <div class="parent_div container-fluid" id="parent_div">


        <section class="">
            <div class="row">
                <div class=" clo_1  col-md-8 col-sm-12 d-flex flex-column justify-content-center  ">
                    <div class="clo_1_sub d-flex flex-column justify-content-center">

                        <h1 style="font-size: 50px;">
                            <div>
                                <h6>Welcome to</h6>
                            </div>
                            <div>
                                <h1>LIGHT LETTERS</h1>
                            </div>
                        </h1>
                        <p>
                            There are many variations of passages of Lorem Ipsum available.but the majority have suffered alteration
                            in
                            some form by injected humour , or randomised words which don't look even slightly believable.
                        </p>
                        <div class="img_div" style="bottom:15px;position: absolute;">
                            <small>powered by LIGHT LETTERS</small>
                        </div>
                        <div class="img_div" style="bottom: 0;right: 14px;position: absolute;">
                            <img src="img/Group 255.svg" alt="Snow">
                        </div>

                    </div>

                </div>
                {{-- right side content(only changed item)  --}}
                @yield('content')
            </div>

        </section>



    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- my included JavaScript -->
   
    <script src="{{url('assets/js/custom.js')}}"></script>
    
<script>
  // var cls=append("class='abc'")
    //$("h6").replaceWith("<h6 class='abc'");
    //  val=$("h6").html();
    // console.log(val);


</script>
</body>
</html>
