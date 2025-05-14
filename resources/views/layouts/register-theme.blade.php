<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>{{$settings->company_name}} | Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">

</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="card">
                    <div class="col-md-3 col-md-offset-1" style="background-image: url('../../images/{{$settings->background}}'); background-repeat: no-repeat; background-size: cover; background-color: light-blue; min-height: 300px;">
                        <div class="overlay"></div>
                        <div class="content text">
                            <h1 class="heading">{{$settings->company_name}}</h1>
                            <p>{{$settings->motto}}</p>
                        </div>
                    </div>
					<div class="col-md-6 col-md-offset-1">
						<div class="content" style="padding: 15px;">
                                <!-----------------------------START YIELD PAGE CONTENT -->
                                @yield('content')
                                <!----------------------------END YIELD PAGE CONTENT -->
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END WRAPPER -->
    </body>
    
    </html>
    <script src="{{asset('/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/scripts/jquery-ui.js')}}"></script>
    <script>
		$( function() {
		  $( "#date,#from,#to,#dob" ).datepicker({dateFormat: "yy/mm/dd"});

		  $(".ui-datepicker, .ui-widget").draggable().selectable();
		});
	</script>
    
                            