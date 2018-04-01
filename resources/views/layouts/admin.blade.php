<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="aksmtr">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="icon" href="assets/img/favicon.png">

	<title>Admin Backend</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">

	<!-- CSS - REQUIRED - START -->
	<!-- Batch Icons -->
	<link rel="stylesheet" href="{{ asset('fonts/batch-icons.css') }}">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}">
	<!-- Custom Scrollbar -->
	<link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
	<!-- Hamburger Menu -->
	<link rel="stylesheet" href="{{ asset('css/hamburgers.css') }}">

	<!-- CSS - REQUIRED - END -->

	<!-- CSS - OPTIONAL - START -->
	<!-- Font Awesome -->
	
	<!-- QuillPro Styles -->
	<link rel="stylesheet" href="{{ asset('css/admin.core.css') }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
	

	@yield('page.css')

	<style>
		#loadingDiv{
			position: fixed;
			top: 50%;
			left: 30%;
			width: 40%;
			height: 65px;
			background-color: #fff;
			z-index: 10000000;
			opacity: 0.9;
			padding: 20px;
			border: 1px solid #AAA;
			box-shadow: 8px 8px 20px #888;
			display: table;
		}
	</style>
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			@yield('aside')
            
            
			<div class="right-column">
				<nav class="navbar navbar-expand-lg navbar-light bg-white">
					<button class="hamburger hamburger--slider" type="button" data-target=".sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle Sidebar">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>

					<div class="navbar-collapse" id="navbar-header-content">
                        <div class="mr-auto">
							@yield('header')
						</div>

						<ul class="navbar-nav navbar-notifications float-right">
							
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle no-waves-effect" id="navbar-notification-misc" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
									<i class="batch-icon batch-icon-bell"></i>
									<span class="notification-number">4</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right dropdown-menu-md" aria-labelledby="navbar-notification-misc">
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-bell batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">General Notification</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">Just now</span>
											</div>
										</a>
									</li>
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-cloud-download batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Your Download Is Ready</h6>
												<div class="notification-text">
													Nibh amet cras sit libero
												</div>
												<span class="notification-time">5 minutes ago</span>
											</div>
										</a>
									</li>
									
								</ul>
							</li>
						</ul>
						@include('partials.userbar-admin')
					</div>
				</nav>

				<main class="main-content p-5" role="main">
					
						@include('flash::message')

						@yield('main')
					
					<div class="row mb-4">
						<div class="col-md-12">
							<footer>
								&copy; {{ date("Y") }} aksmtr.com
							</footer>
						</div>
					</div>
				</main>
			</div>
		</div>
	</div>

	<!-- SCRIPTS - REQUIRED START -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Bootstrap core JavaScript -->
    <!-- JQuery -->
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    
	<!-- Popper.js - Bootstrap tooltips -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<!-- Bootstrap core JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
	<!-- Velocity -->
	<!-- <script type="text/javascript" src="assets/plugins/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="assets/plugins/velocity/velocity.ui.min.js"></script> -->
	<!-- Custom Scrollbar -->
	<script type="text/javascript" src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<!-- jQuery Visible -->
	<!-- <script type="text/javascript" src="assets/plugins/jquery_visible/jquery.visible.min.js"></script> -->
	<!-- jQuery Visible -->
	<!-- <script type="text/javascript" src="assets/plugins/jquery_visible/jquery.visible.min.js"></script> -->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<!-- <script type="text/javascript" src="assets/js/misc/ie10-viewport-bug-workaround.js"></script> -->

	<!-- SCRIPTS - REQUIRED END -->

	<!-- SCRIPTS - OPTIONAL START -->
	<!-- ChartJS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js" integrity="sha256-RtrB/Bgt7EpDgAWIsLodnrtWCCcUCYtZOnuR6bxpSiM=" crossorigin="anonymous"></script>
	<!-- JVMaps -->
	<!-- <script type="text/javascript" src="assets/plugins/jvmaps/jquery.vmap.min.js"></script> -->
	<!-- <script type="text/javascript" src="assets/plugins/jvmaps/maps/jquery.vmap.usa.js"></script> -->
	<!-- Image Placeholder -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js" integrity="sha256-ifihHN6L/pNU1ZQikrAb7CnyMBvisKG3SUAab0F3kVU=" crossorigin="anonymous"></script>
	<!-- SCRIPTS - OPTIONAL END -->

	<!-- QuillPro Scripts -->
	<script type="text/javascript" src="{{ asset('js/admin.core.js') }}"></script>

	<!-- application script -->
	<script src="{{ asset('js/app.js') }}"></script>

	@yield('page.script')
</body>
</html>
