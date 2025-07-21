<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Last Supporter | Card Flip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <style>
        .card-footer {
            box-shadow: 0px 5px #888888;
        }
    </style>
</head>

<body>

    <div class="card-footer border-top-0 rounded-pill">
       <marquee behavior="33" direction="" class="position-relative" >
          
             Lorem ipsum dolor sit amet consectetur adipisicing elit.  <span> <img src="{{ asset('template/images/icon/bendera.png') }}" alt="story-img" class=""></span> Lorem, ipsum do <span> <img src="{{ asset('template/images/omg.png') }}" alt="" class="" width="20" height="20"> </span>
       </marquee>
       <div class="label p-2  bg-warning position-absolute top-0 rounded-pill " style="left: 0" >
               <img src="{{ asset('template/images/omg.png') }}" alt="" class="" width="30" height="30">
           </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if (!isset($qParams['iframe']))
    <script src="{{ asset('js/echo.js') }}"></script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

</body>

</html>