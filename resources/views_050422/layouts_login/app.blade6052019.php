<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="{{ asset('images/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
<script src="{{ asset('js/jquery-1.12.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app_login.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app_login.css') }}" rel="stylesheet">

</head>
<body>
  
       

        <div class="container">
            @yield('content')
			
        </div>
   
</body>
</html>