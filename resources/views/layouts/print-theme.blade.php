<!doctype html>
<html lang="en">

<head>
	<title> {{ Auth::user()->settings->company_name ?? 'AutoServe' }} | AutoServe ERP</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
     
	<style>
	  .letter-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 20px;
		border-bottom: 3px solid #ccc;
		font-family: Arial, sans-serif;
		}

	  .logo {
		flex: 0 0 150px;
		}

	  .logo img {
		width: 100%;
		height: auto;
		}

		.company-info {
		text-align: left;
		padding-left: 20px;
		flex: 1;
		}

		.company-name {
		font-size: 36px;
		color: {{ Auth::user()->settings->primary_color }};
		font-weight: bold;
		letter-spacing: 1px;
		}

		.contact-info {
		margin-top: 10px;
		font-size: 16px;
		line-height: 1.6;
		}

		.contact-info span {
		font-weight: bold;
		color: {{ Auth::user()->settings->secondary_color }};
		}
	</style>

</head>

<body onload="window.print()"  style="background-color: white !important;">
	<!-- WRAPPER -->
	    @if(Auth::user()->settings->header != null)
            <img  src="{{ Auth::user()->settings->header ? asset('images/' . Auth::user()->settings->header) : asset('images/asheader.png') }}" alt="{{ Auth::user()->settings->company_name}}" class="img-responsive" style="height: 150px; width: auto;">
		@else
		    <div class="letter-header">
				<div class="logo">
				<img src="{{ asset('images/' . Auth::user()->settings->logo) }}" alt="{{ Auth::user()->settings->company_name }}">
				</div>
				<div class="company-info">
				<div class="company-name">{{ Auth::user()->settings->company_name }}</div>
				<div class="contact-info">
					<div><span>Address: </span>{{ Auth::user()->settings->address}}</div>
					<div><span>Telephone: </span> {{ Auth::user()->settings->phone_number ?? Auth::user()->phone_number }}</div>
					<div><span>Email: </span> {{ Auth::user()->settings->company_email ?? Auth::user()->email }}</div>
				</div>
				</div>
			</div>
		@endif
        <div style="padding: 0px 30px 0px 30px; background-color: white !important;">
            @yield('content')
        </div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>