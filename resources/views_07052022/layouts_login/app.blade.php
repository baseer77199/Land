<?php

header_remove('Access-Control-Allow-Methods');
header_remove('Access-Control-Allow-Origin');
header_remove('Access-Control-Allow-Headers');
header_remove('Access-Control-Allow-Credentials');

$allowed_host=array('172.31.61.248:156','localhost','localhost:156','172.31.61.248','103.74.215.40','ticketingsolutions.lntecc.com:156','ticketingsolutions.lntecc.com');

if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) 
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 421 Misdirected Request');

echo "<html><head>
<title>421 Misdirected Request</title>
</head><body>
<h1>Misdirected Request</h1>
<p>The client needs a new connection for this
request as the requested host name does not match
the Server Name Indication (SNI) in use for this
connection.</p>
</body></html>";

    exit;
}
?>




<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="{{ asset('images/favicon.ico') }}">
    <title>L&T</title>
<script src="{{ asset('js/jquery-1.12.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app_login.js') }}" defer></script>
 -->
    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="https://fonts.gstatic.com">-->
    <!--<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">-->

    <!-- Styles -->
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app_login.css') }}" rel="stylesheet">

</head>
<body>
  <video   autoplay="autoplay"  muted="muted"  loop class="fullscreen-bg__video" >
                <!-- <source src="{{asset('video/homepage_video.webm')}}" type="video/webm"> -->
                 <source src="{{asset('video/june-2019.mp4')}}" type="video/mp4">   
            </video>
       

        <!-- <div class="container"> -->
            @yield('content')
            
       <!--  </div> -->
   
</body>
</html>