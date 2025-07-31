<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<meta name="description" content="Tempatnya content creator cari dukungan!">
<meta name="keywords" content="OMG, Kreatif, Creatif, Streamer, Support, Monetisasi, Monetization">
<meta name="author" content="PT. Qwords Company International">
@yield('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@if (Auth::check())
<meta name="auth" content="{{ Session::get('access_token') }}"> 
@endif
