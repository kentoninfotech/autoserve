<!doctype html>
<html lang="en">

<head>
	<title>Autoserve ERP | Dashboard</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">


	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="{{ asset('image/png" sizes="96x96" href="assets/img/favicon.png') }}">


    <link rel="stylesheet" href="{{asset('/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css')}}">
	<style>
		@media only screen and (max-width: 600px) {
			table {
				display: block;
				overflow-x: auto;
				white-space: nowrap;
			}

			table tbody {
				display: table;
				width: 100%;
			}
		}
		.menuicon {
				visibility:hidden;
				display: none;
		}

		@media only screen and (max-width: 600px) {
			.menuicon {
				visibility:visible;
				display: inline;
			}
		}
        #cover {
			background: url("{{asset('/images/ajax-loader.gif')}}") no-repeat scroll center center #CCC;
			position: absolute;
			height: 100%;
			width: 100%;
			z-index: 999999999;
			opacity: 0.8;
		}

		.tab-content hr{
			border-top: 1px solid green;
		}

		.form-row{
			border-bottom: 0.5px solid green;
			margin-bottom: 5px;
		}

		label{
			color: darkgreen;
			font-size: small;
		}

		.tab-content span{
			margin-right: 7px;
			font-size: smaller;
			vertical-align:text-top;
		}
		.btnNext{
			float: right;
		}

        .btn-success{
            /* background-color: #032f69 !important; LAC*/
            background-color: #5e9a52 !important;
        }

        .btn-primary{
            /* background-color: #032f69 !important; LAC*/
            background-color: #5e9a52 !important;

        }
	</style>
</head>

<body>
{{-- <div id="cover"></div> --}}
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top" style="clear: both !important;">
			<div class="brand">
				<a href="{{url('/')}}"><img  src="{{asset('images/'.$settings->logo)}}" alt="{{$settings->motto}}" class="img-responsive logo" style="height: 35px !important; float: left;"></a> <b>{{$settings->ministry_name}}</b>
				<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-menu"></i></button>
			</div>

			<div class="container-fluid" style="width: 100%">
				<form class="navbar-form navbar-left" action="{{ route('searchjobs') }}" method="post">
					@csrf
					<div class="input-group">
						<input type="text" name="keyword" list="allcontacts" class="form-control" placeholder="Search Customers, Jon No, Org, CustomerID...">
						<datalist id="allcontacts">
							@foreach ($allcontacts as $con)
								<option value="{!!$con->name!!}" data-customerid="{{$con->customerid}}">{!!$con->organization!!}</option>
							@endforeach
						</datalist>
						<span class="input-group-btn"><button type="submit" class="btn btn-primary">Go</button></span>
					</div>
				</form>




				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
                    <li class="menuicon">

					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-menu"></i></button>

                    </li>

						@auth
						<li class="dropdown">


								<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
									<i class="lnr lnr-alarm"></i>
									@if ($mytasks->count()>0)
										<span class="badge bg-danger">{{$mytasks->count()}} <!-- Some Laravel Counter --></span>
									@endif
								</a>


							<ul class="dropdown-menu notifications">
								@foreach ($mytasks as $ts)
									<li><a href="{{url('tasks')}}" class="notification-item"><span class="dot bg-warning"></span>{{$ts->title}} | <i class="lnr lnr-clock"></i>{{$ts->date}}</a></li>
								@endforeach
								<li><a href="{{url('tasks')}}" class="more">See all notifications</a></li>
							</ul>
						</li>
						@endauth
						<li>
							<a href="{{url('/')}}"><i class="lnr lnr-home"></i> <span>Home</span></a>

						</li>


						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="lnr lnr-user"></i> <span>@auth {{ Auth::user()->name }} @endauth </span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li class="roledlink Admin Super Front-Desk"><a class="btn btn-success update-pro" href="{{url('newjob')}}" title="New Customer" target="_blank" style="color: white; font-weight: bold;"><span class="fa fa-user-plus"></span> <span>New Customer</span></a></li>
								<li class="roledlink Admin Super"><a href="{{url('my_profile/'.$login_user->id ?? '')}}"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<li><a href="{{url('tasks')}}"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>

								<li class="roledlink Admin Super" style="visibility:hidden !important;"><a href="#"  data-toggle="modal" data-target="#settings"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li><a href="{{url('help')}}"><i class="lnr lnr-bubble"></i> Basic Use</a></li>
								<li><a href="{{url('security')}}"><i class="lnr lnr-lock"></i> Security</a></li>
								<li><a href="{{url('logout')}}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>



					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar" style="margin-top: 10px">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{url('home')}}" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>


						<li class="roledlink Front-Desk Admin Followup Finance Super Spare-Parts" style="visibility:hidden;">
							<a href="#subPages2" data-toggle="collapse" class="collapsed"><i class="lnr lnr-users"></i> <span>Customers</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages2" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('newjob')}}" class="roledlink Admin Front-Desk Spare-Parts Super">Add New Customer</a></li>
									<li><a href="{{url('customers')}}" class="roledlink Admin Front-Desk Spare-Parts Super">All Customers</a></li>
									<li><a href="{{url('vehicles')}}" class="roledlink Admin Front-Desk Super Spare-Parts">All Vehicles</a></li>

								</ul>
							</div>
						</li>
						<li class="roledlink Front-Desk Finance Admin Super" style="visibility:hidden;">
							<a href="#subPages3" data-toggle="collapse" class="collapsed"><i class="lnr lnr-briefcase"></i> <span>Jobs</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages3" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('newjob')}}" class="roledlink Front-Desk Admin Super">New Job</a></li>
									<li><a href="{{url('jobs')}}" class="roledlink Front-Desk Admin Super Finance">Pending Jobs</a></li>
									<li><a href="{{url('completedjobs')}}" class="roledlink Front-Desk Admin Super Finance">Completed Jobs</a></li>
                                    <li><a href="{{url('job-controls')}}" class="roledlink Front-Desk Admin Super">Job Control Management</a></li>
                                    <li><a href="{{url('attendance')}}" class="roledlink Front-Desk Admin Super">Attendance Management</a></li>

								</ul>
							</div>
						</li>

                        <li class="roledlink Spare-Parts Admin Super" style="visibility:hidden;">
							<a href="#subPages8" data-toggle="collapse" class="collapsed"><i class="fa fa-list"></i> <span>Sales/Inventory</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages8" class="collapse ">
								<ul class="nav">
                                    <li><a href="{{url('new-sales')}}" class="roledlink Front-Desk Admin Super">New Sales</a></li>
									<li><a href="{{url('parts')}}" class="roledlink Front-Desk Admin Super Spare-Parts">Automobile Parts</a></li>
									<li><a href="{{url('supplies')}}" class="roledlink Front-Desk Admin Super Spare-Parts">Supplies</a></li>
									<li><a href="{{url('sales')}}" class="roledlink Front-Desk Finance Admin Super Spare-Parts">Sales</a></li>
                                    <li><a href="{{url('deliveries')}}" class="roledlink Front-Desk Finance Admin Super">Deliveries</a></li>
								</ul>
							</div>
						</li>

						<li class="roledlink Admin Finance Super" style="visibility:hidden;">
							<a href="#subPages4" data-toggle="collapse" class="collapsed"><i class="fa fa-dollar"></i> <span>Payments</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages4" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('transactions')}}" class="roledlink Cashier Finance Admin Super">All Transactions</a></li>
                                    <li><a href="{{url('payments')}}" class="roledlink Cashier Finance Admin Super">Payments</a></li>
									<li><a href="{{url('debtors')}}" class="roledlink Cashier Finance Admin Super">Debtors</a></li>
                                    <li><a href="{{url('account-heads')}}" class="roledlink Cashier Finance Admin Super">Account Heads</a></li>

								</ul>
							</div>
						</li>

						<li class="roledlink Front-Desk Admin Super" style="visibility:hidden;">
							<a href="#subPages5" data-toggle="collapse" class="collapsed"><i class="fa fa-handshake-o"></i> <span>Post Service</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages5" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('reminders')}}" class="roledlink Front-Desk Admin Super">Reminders</a></li>
									<li><a href="{{url('psfu')}}" class="roledlink Front-Desk Admin Super">Post Service Followup</a></li>
									<li><a href="{{url('allpsfus')}}" class="roledlink Front-Desk Admin Super">PSFU Reports</a></li>
								</ul>
							</div>
						</li>

						<li class="roledlink Front-Desk Finance Admin Super" style="visibility:hidden;">
							<a href="#subPages6" data-toggle="collapse" class="collapsed"><i class="fa fa-phone"></i> <span>Communication</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages6" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('communications')}}" class="roledlink Front-Desk Admin Super">Send SMS Messages</a></li>
									<li><a href="{{url('sentmessages')}}" class="roledlink Front-Desk Admin Super">Sent Messages</a></li>
									<li><a href="{{url('tasks')}}" class="roledlink Front-Desk Finance Admin Super">Tasks/Inbox</a></li>
								</ul>
							</div>
						</li>

						<li class="roledlink Finance Front-Desk Admin Super" style="visibility:hidden;">
							<a href="#subPages7" data-toggle="collapse" class="collapsed"><i class="fa fa-gear"></i> <span>Settings</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages7" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('personnels')}}" class="roledlink Admin Super">Personnel</a></li>
									<li><a href="{{url('users')}}" class="roledlink Admin Super">Users</a></li>
									<li><a href="{{url('backup')}}" class="roledlink Admin Finance Front-Desk  Super">Backup</a></li>
								</ul>
							</div>
						</li>

					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-----------------------------START YIELD PAGE CONTENT -->
					@if (Session::get('message'))
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<i class="fa fa-check-circle"></i> {!!Session::get('message')!!}
						</div>
					@endif

                    @if (Session::get('error'))
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<i class="fa fa-check-circle"></i> {!!Session::get('error')!!}
						</div>
					@endif
					@yield('content')

					<!----------------------------END YIELD PAGE CONTENT -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; {{date("Y")}} <a href="https://www.gintecservices.com.ng" target="_blank">Gintec Global Services </a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{asset('/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('/assets/scripts/klorofil-common.js')}}"></script>
	<script src="{{asset('/assets/scripts/jquery-ui.js')}}"></script>
	<script>
		$( function() {
		  $( "#date,#from,#to,#dob,.date" ).datepicker({dateFormat: "yy-mm-dd"});

		  $(".ui-datepicker, .ui-widget").draggable().selectable();
		});
	</script>
</body>

</html>

<!-- The Settings Modal -->
<div class="modal" id="settings">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add New Post</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

            <form method="POST" action="{{ route('settings') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{$settings->id}}">

				<input type="hidden" name="oldlogo" id="id" value="{{$settings->logo}}">

				<input type="hidden" name="oldbackground" id="id" value="{{$settings->background}}">

                <div class="form-group">
                    <label for="ministry_name">Organization</label>
                    <input type="text" name="ministry_name" id="ministry_name" class="form-control" value="{{$settings->ministry_name}}">
                </div>

				<div class="form-group">
                    <label for="motto">Motto</label>
                    <input type="text" name="motto" id="motto" class="form-control" value="{{$settings->motto}}">
                </div>

				<div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{$settings->address}}">
                </div>




                <div class="form-group">
                    <label for="logo">Upload Logo Image</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>

				<div class="form-group">
                    <label for="background">Upload Background Image</label>
                    <input type="file" name="background" id="background" class="form-control">
                </div>

				<div class="form-group">
				  <label for="mode">Mode</label>
				  <select class="form-control" name="mode" id="mode">
					  <option value="{{$settings->mode}}">{{$settings->mode}}</option>
					<option value="Active" selected>Active</option>
					<option value="Maintenance">Maintenance</option>
				  </select>
				</div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Settings') }}
                    </button>
                </div>


            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
</div>

<div class="modal" id="invoicedate">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Invoice Date</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
			<form action="{{ route('changedate') }}" method="post" class="changedate">
				@csrf
				<input type="hidden" name="jobno" id="idchange">
				<div class="col-md-8">
					<input type="text" name="changedate" id="changedate" class="date">
				</div>
				<div class="col-md-4">
					<button class="btn btn-primary btn-xs">Change</button>
				</div>
			</form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
</div>


@if (isset($pagename) && $pagename=="dashboard")
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/light.js"></script>
	<script>

		AmCharts.makeChart("performancechart",
			{
				"type": "serial",
				"categoryField": "Date",
				"maxZoomFactor": 16,
				"startDuration": 1,
				"theme":"light",
				"categoryAxis": {
					"gridPosition": "start"
				},
				"trendLines": [],
				"graphs": [
					{
						"balloonText": "[[title]] of [[category]]:[[value]]",
						"fillAlphas": 1,
						"id": "AmGraph-1",
						"labelText": "[[value]]",
						"title": "Customers Serviced",
						"type": "column",
						"valueField": "Total_Customers"
					},
					{
						"balloonText": "[[title]] of [[category]]:[[value]]",
						"bullet": "round",
						"id": "AmGraph-2",
						"labelText": "[[value]]",
						"lineThickness": 2,
						"title": "Jobs Done",
						"valueField": "Total_Jobs"
					}
				],
				"guides": [],
				"valueAxes": [
					{
						"id": "ValueAxis-1",
						"title": "Number of Customers/Vehicles"
					}
				],
				"allLabels": [],
				"balloon": {},
				"legend": {
					"enabled": true,
					"useGraphSettings": true
				},
				"titles": [
					{
						"id": "Title-1",
						"size": 15,
						"text": "Performance Analysis"
					}
				],
				"dataProvider": <?php echo $chartdata; ?>
			}
		);
	</script>
@endif


@if (isset($pagetype) && $pagetype=="report")

	<script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('/js/jszip.min.js')}}"></script>
	<script src="{{asset('/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.searchPanes.min.js')}}"></script>
	<script src="{{asset('/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('/js/buttons.colVis.min.js')}}"></script>


	<script>


		// TABLES WITH FILTERS
		$('#products thead tr').clone(true).appendTo( '#products thead' );
		$('#products thead tr:eq(1) th:not(:last)').each( function (i) {
			var title = $(this).text();
			$(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" value="" />' );

			$( 'input', this ).on( 'keyup change', function () {
				if ( table.column(i).search() !== this.value ) {
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		} );


		var table = $('#products,.products2').DataTable( {
			orderCellsTop: true,
			fixedHeader: true,
			"paging": true,
			"footer": false,
			"pageLength": 100,
			"filter": true,
			"ordering": true,
			deferRender: true,
			dom: 'Bfrtip',
			"order": [0, "asc"],

			buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
			{
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
			{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },

				'csv', 'print','colvis',

			]
		});





		$('.buttons-pdf').click(function(){
			$("#products th:last-child, #products td:last-child").remove();
		})
	</script>
@endif


	<script>
		function changeDate(jobno){
			$('#idchange').val(jobno);
		}
		function accountHead(accid){


					var title = $('#ach'+accid).attr("data-title");
					var category = $('#ach'+accid).attr("data-category");
					var type = $('#ach'+accid).attr("data-type");
					var description = $('#ach'+accid).attr("data-description");

					$('#id').val(accid);
					$('#title').val(title);
					$('#category').val(category).attr("selected", "selected");
					$('#type').val(type);
					$('#description').val(description);
		}


		function transaction(accid){

			var title = $('#ach'+accid).attr("data-title");
			var date = $('#ach'+accid).attr("data-date");
			var account_head = $('#ach'+accid).attr("data-account_head");
			var amount = $('#ach'+accid).attr("data-amount");
			var reference_no = $('#ach'+accid).attr("data-reference_no");
			var detail = $('#ach'+accid).attr("data-detail");
			var from = $('#ach'+accid).attr("data-from");
			var to = $('#ach'+accid).attr("data-to");
			var approved_by = $('#ach'+accid).attr("data-approved_by");
			var recorded_by = $('#ach'+accid).attr("data-recorded_by");

			$('#title').val(title);
			$('#id').val(accid);
			$('#date').val(date);
			$('#account_head').val(account_head).attr("selected", "selected");
			$('#amount').val(amount);
			$('#reference_no').val(reference_no);
			$('#detail').val(detail);
			$('#from').val(from).attr("selected", "selected");
			$('#to').val(to).attr("selected", "selected");
			$('#approved_by').val(approved_by).attr("selected", "selected");
			$('#recorded_by').val(recorded_by).attr("selected", "selected");

		}


		function addnumber(number){
			var receivers = $('#recipients').val();

			if(number=="all"){

				if(receivers==""){
					$('#recipients').val($('#all').attr('data-allnumbers'));
				}else{
					$('#recipients').val('');
				}


			}else{
				if($("#recipients").val().indexOf(','+number) >= 0){



					$('#recipients').val(receivers.replace(','+number,''));

				}else if($("#recipients").val().indexOf(number+',') >= 0){


					$('#recipients').val(receivers.replace(number+',',''));

				}else if($("#recipients").val().indexOf(number) >= 0){


					$('#recipients').val(receivers.replace(number,''));

				}else{
					if(receivers==""){

						$('#recipients').val(number);
					}else{
						$('#recipients').val(receivers+','+number);
					}

				}
			}

		}

		// ADD PARTS LIST

        function updateId(pnid){
            var val = $('#pn'+pnid).val();
            var pid = $('#productslist option').filter(function() {
                return this.value == val;
            }).data('pid');

            var instock = $('#productslist option').filter(function() {
                return this.value == val;
            }).data('instock');

            var price = $('#productslist option').filter(function() {
                return this.value == val;
            }).data('price');


            /* if value doesn't match an option, xyz will be undefined*/
            var pidd = pid ? pid : '';
            $("#pnid"+pnid).val(pidd);
            $("#instock"+pnid).html("In Stock: "+instock);
            $("#r"+pnid).val(price);
            $("#a"+pnid).val(price);
        };

        function getServiceCost(serviceid){
            var val = $('#sn'+serviceid).val();

            var samount = $('#servicelist option').filter(function() {
                return this.value == val;
            }).data('servicecost');

            if (!$.isNumeric(samount)) {
                samount = 0;
            }


            $("#labour").val(samount);
        };

		function addPl(){
			// plid=plid+1;

			$(this).text("+ Add More Parts");
			var plid = $('div .partslist:last').attr('id');

            if(plid==null){
                plid = 0;
            }
			var newid = parseInt(plid);
			newid+=1;

			$("#parts").append('<div class="row form-row partslist" id="'+newid+'"><div class="form-group col-md-4"><div class="form-group"><input list="productslist" class="form-control partname" name="partname[]" placeholder="Part Name"  id="pn'+newid+'" onchange="updateId('+newid+')"><input type="hidden" name="pnid[]" id="pnid'+newid+'"><span><small id="instock'+newid+'"></small></span></div></div><div class="form-group col-md-2"><div class="form-group"><input type="number" class="form-control quantity" name="quantity[]" id="q'+newid+'" value="1"></div></div><div class="form-group col-md-2"><div class="form-group"><input type="number" step="0.01" class="form-control rate" name="rate[]" id="r'+newid+'" value="1"></div></div><div class="form-group col-md-3"><div class="form-group"><input type="number" step="0.01" class="form-control amount" name="amount[]"  id="a'+newid+'" value="0"></div></div><div class="form-group col-md-1"><span class="btn btn-xs btn-primary premover" onclick="removePl('+newid+')">Remove</span></div></div>');
		}

        function addService(){
			// plid=plid+1;

			$(this).text("+ Add More Service");
			var slid = $('div .serviceslist:last').attr('id');

            if(slid==null){
                slid = 0;
            }
			var newsid = parseInt(slid);
			newsid+=1;

			$("#services").append('<div class="row form-row serviceslist" id="'+newsid+'"><div class="form-group col-md-6"><div><input list="servicelist" value="Routine Maintenance" placeholder="Routine Maintenance" name="servicename[]" class="form-control"  id="sn'+newsid+'"  onchange="getServiceCost('+newsid+')"></div></div><div class="form-group col-md-5"><div><input type="text" placeholder="Description" name="description[]" class="form-control" ></div></div><div class="form-group col-md-1"><span class="btn btn-xs btn-primary premover" onclick="removeSl('+newsid+')">Remove</span></div></div>');
		}

		// REMOVE PARTS LIST
		function removePl(plid){
			$('#'+plid).remove();
		}

        // REMOVE SERVICE
        function removeSl(slid){
			$('#sl'+slid).remove();
		}

        function addPr(){
			// plid=plid+1;
			$(this).text("+ Add More Products");
			var plid = $('div .productslist:last').attr('id');
			var newid = parseInt(plid);
			newid+=1;

			$("#productsales").append('<div class="row form-row productslist" id="'+newid+'"><div class="form-group col-md-4"><div class="form-group"><input list="productslist" class="form-control partname" name="partname[]" placeholder="Part Name"  id="pn'+newid+'" onchange="updateId('+newid+')"><input type="hidden" name="pnid[]" id="pnid'+newid+'"><span><small id="instock'+newid+'"></small></span></div></div><div class="form-group col-md-2"><div class="form-group"><input type="number" class="form-control quantity" name="quantity[]" id="q'+newid+'" value="1"></div></div><div class="form-group col-md-2"><div class="form-group"><input type="number" step="0.01" class="form-control rate" name="rate[]" id="r'+newid+'" value="1"></div></div><div class="form-group col-md-3"><div class="form-group"><input type="number" step="0.01" class="form-control amount" name="amount[]"  id="a'+newid+'" value="0"></div></div><div class="form-group col-md-1"><span class="btn btn-xs btn-primary premover" onclick="removePl('+newid+')">Remove</span></div></div>');
		}

		// REMOVE PARTS LIST
		function removePr(plid){
			$('#'+plid).remove();
		}


		// GO TO DIAGNOSIS TAB

		$('#gotodiagnosis').click(function(){
			var nextId = $(this).parents('.tab-pane').nextAll(':lt(5)').attr("id");
			$('[href="#'+nextId+'"]').tab('show');
		})

		$('#gotodiagnosis').click(function() {
			$('#jobordertabs a[href="#tab4"]').tab('show');
		});

		$(document).on('click', '#partsaddbtn', function () {
			var addtext =  $(this).text();
			if(addtext=="Add Parts"){
				$(this).text("+ Add More Parts");
			}
		});

		$(document).on('input click change', '.quantity,.amount,.rate,#labour,#discountpercent,.btnNext,#sundrycost,.premover,.sundry,.vat', function () {
			$('.rate').each(function(i, obj) {
				var id = $(this).attr('id').substring(1);
				// alert(id);
				var rate =  parseFloat($('#r'+id).val());
				var quantity =  parseFloat($('#q'+id).val());

				$("#a"+id).val(rate*quantity);

			});
			var vatPercent =  parseFloat($('input[name="vat"]:checked').val()) || 0;
			var sundry =  parseFloat($('input[name="sundry"]:checked').val()) || 0;
			var labour =  parseFloat($("#labour").val()) || 0;
			var sundrycost =  parseFloat($("#sundrycost").val()) || 0;
			var oldtotalamount =  parseFloat($("#oldtotalamount").val()) || 0;
			var discountpercent =  parseFloat($("#discountpercent").val()) || 0;

			// alert(oldtotalamount);


			// var total =  $("#vat").val();
			// var vatPercent =  $("#vat").val();
			// var vatPercent =  $("#vat").val();

			var sumAmount = 0;
			var discount = 0;
			$('.amount').each(function(){
				sumAmount += parseFloat($(this).val());
			});

			// ADDED LABOUR IN VAT
			// var vat = ((sumAmount+labour+sundry)/100)*vatPercent

			if(parseFloat(oldtotalamount) == parseFloat((sumAmount+labour))){
				sundry = 0;
			}

			if(sundrycost>0){
				sundry = sundrycost;
			}

			var totalAmount = parseFloat(sumAmount+sundry+labour);

			if(discountpercent>0){
				discount = (totalAmount/100)*discountpercent;
				totalAmount = parseFloat(totalAmount-discount);
			}


            // CALCULATE VAT
			var vat = (totalAmount/100)*vatPercent;

            var totalAmount = parseFloat(totalAmount+vat);

			$("#vatcost").val(vat);
			$("#sundrycost").val(sundry);
			$("#discountcost").val(discount);
			$("#totalamount").val(totalAmount);
		});


		// CHECK ALL
		$('#all').click(function(event) {
			if(this.checked) {
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;
				});
			}
		});

		// TEXT AREA Counter
		$('#body').on("input", function(){
			var maxlength = $(this).attr("maxlength");
			var currentLength = $(this).val().length;
			$("#charcounter").text(currentLength + " characters");
			$("#pagecounter").text(Math.ceil(currentLength/160) + " pages");

			if( currentLength >= maxlength ){
				$("#error").text("You have reached the maximum number of characters.");
			}else{
				$("#charleft").text(maxlength - currentLength + " chars left");

			}
		});

		// MANAGE ROLES AND ACCESS
		var usrRole = "{{$login_user->role ?? ''}}";

		$(".roledlink,#mergebtn").hide();

		$('.mergeselector').click(function(){
			$('#mergebtn').show();
			var mainaccount = $("#mainaccount").val();

			if(mainaccount==""){
				$("#mainaccount").val($(this).val())
			}
		});

		function protect() {
			$("." + usrRole).css("visibility", "visible");
			$("." + usrRole).show();
		}
		protect();

		$(window).on('load', function(){
			$('#cover').fadeOut(1000);
		});

		$('.btnNext').click(function(){
			$('.nav-tabs > .active').next('li').find('a').trigger('click');
		});

		$('.btnPrevious').click(function(){
			$('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});

		$("#name").on('blur',function(e){
			var option = $('#names option').filter(function() {
				return this.value === $("#name").val();
			});

			if(option.val()){
				// alert(option+"Found")
				var ask = window.confirm("The name: "+option.val()+"-"+ option.data('customerid')+" that you entered already exists. Go to this Customer's Vehicles instead to continue?");
				if (ask) {
					// window.alert("This post was successfully deleted.");
					window.location.href = "/customer-vehicles/"+option.data('customerid');
				}
			}

		});

        $("#nameTrigger").on('blur',function(e){
			var option = $('#names option').filter(function() {
				return this.value === $("#nameTrigger").val();

			});

			if(option.val()){
				// alert(option+"Found")

				var ask = window.confirm("The name: "+option.val()+"-"+ option.data('customerid')+" that you entered already exists. Select Products for sale instead?");
				if (ask) {
                    $("#customerid").val(option.data('customerid'));
                    $('.nav-tabs > .active').next('li').find('a').trigger('click');
				}
			}

		});
	</script>



