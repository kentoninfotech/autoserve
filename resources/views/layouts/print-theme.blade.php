<!doctype html>
<html lang="en">

<head>
	<title>Auto Prince Technologies | Autoserve ERP</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">


</head>

<body onload="window.print()"  style="background-color: white !important;">
	<!-- WRAPPER -->
            <img  src="{{ asset('/images/aptheader.png') }}" alt="{{ Auth::user()->settings->motto}}" class="img-responsive" style="height: 150px; width: auto;">

        <div style="padding: 0px 30px 0px 30px; background-color: white !important;">
            @yield('content')
        </div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>