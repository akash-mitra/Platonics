<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="QuillPro is multipurpose Bootstrap 4 Admin Dashboard Template that allows you build and launch your projects in the quickest time possible.">
	<meta name="author" content="Base5Builder">
	<link rel="icon" href="assets/img/favicon.png">

	<title>Admin Backend</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">

	<!-- CSS - REQUIRED - START -->
	<!-- Batch Icons -->
	<link rel="stylesheet" href="fonts/batch-icons.css">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="css/mdb.min.css">
	<!-- Custom Scrollbar -->
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
	<!-- Hamburger Menu -->
	<link rel="stylesheet" href="css/hamburgers.css">

	<!-- CSS - REQUIRED - END -->

	<!-- CSS - OPTIONAL - START -->
	<!-- Font Awesome -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- JVMaps -->
	<!-- <link rel="stylesheet" href="assets/plugins/jvmaps/jqvmap.min.css"> -->
	<!-- CSS - OPTIONAL - END -->

	<!-- QuillPro Styles -->
	<link rel="stylesheet" href="css/admin.core.css">
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<nav id="sidebar" class="px-0 bg-dark bg-gradient sidebar">
				<ul class="nav nav-pills flex-column">
					<li class="logo-nav-item">
						<a class="navbar-brand" href="#">
                            <!-- <img src="assets/img/logo-white.png" width="145" height="32.3" alt="QuillPro"> -->
                            BlogVel Admin
						</a>

                    </li>
                    
                    <li class="nav-item">
						<a class="nav-link active" href="index.html">
							<i class="batch-icon batch-icon-browser-alt"></i>
							Dashboard <span class="sr-only">(current)</span>
						</a>
                    </li>
                    
					<li>
						<h6 class="nav-header">Content</h6>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('page-index')}}">
                            <i class="batch-icon batch-icon-paragraph-alt-justify"></i>&nbsp;Pages
                        </a>	
                    </li>	

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon  batch-icon-folder"></i>&nbsp;Categories
                        </a>
                    </li>
					
					<li class="nav-item">
						<a class="nav-link nav-parent" href="#">
							<i class="batch-icon batch-icon-layout-content-left"></i>
							Layout
						</a>
						<ul class="nav nav-pills flex-column">
							<li class="nav-item">
								<a class="nav-link" href="layout-left-menu-hidden.html">Left Menu - Hidden</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="layout-left-menu-normal.html">Left Menu - Normal</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="layout-top-menu-fixed.html">Top Menu - Fixed</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="layout-top-menu-normal.html">Top Menu - Normal</a>
							</li>
						</ul>
					</li>
				</ul>

				<ul class="nav nav-pills flex-column">
					<li>
						<h6 class="nav-header">Manage</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-users"></i>&nbsp;Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-speech-bubble-left-tip-chat"></i>&nbsp;Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-inbox"></i>&nbsp;Posts
                        </a>
                    </li>
					
				</ul>

                <ul class="nav nav-pills flex-column">
					<li>
						<h6 class="nav-header">Setting</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-nib"></i>&nbsp;Design
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-credit-card-alt-3"></i>&nbsp;Revenue
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category-index')}}">
                            <i class="batch-icon batch-icon-flask-full"></i>&nbsp;Advance
                        </a>
                    </li>
					
				</ul>
				
            </nav>
            
            
			<div class="right-column">
				<nav class="navbar navbar-expand-lg navbar-light bg-white">
					<button class="hamburger hamburger--slider" type="button" data-target=".sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle Sidebar">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>

					<div class="navbar-collapse" id="navbar-header-content">
                        <div class="mr-auto"></div>

						<!-- <ul class="navbar-nav navbar-language-translation mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" id="navbar-dropdown-menu-link" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
									<i class="batch-icon batch-icon-book-alt-"></i>
									English
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbar-dropdown-menu-link">
									<li><a class="dropdown-item" href="#">Français</a></li>
									<li><a class="dropdown-item" href="#">Deutsche</a></li>
									<li><a class="dropdown-item" href="#">Español</a></li>
								</ul>
							</li>
						</ul> -->
						<ul class="navbar-nav navbar-notifications float-right">
							<!-- <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" id="navbar-notification-search" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
									<i class="batch-icon batch-icon-search"></i>
								</a>
								<ul class="dropdown-menu dropdown-menu-fullscreen" aria-labelledby="navbar-notification-search">
									<li>
										<form class="form-inline my-2 my-lg-0 no-waves-effect">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search for...">
												<span class="input-group-btn">
													<button class="btn btn-primary btn-gradient waves-effect waves-light" type="button">Search</button>
												</span>
											</div>
										</form>
									</li>
								</ul>
							</li> -->
							<!-- <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle no-waves-effect" id="navbar-notification-calendar" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
									<i class="batch-icon batch-icon-calendar"></i>
									<span class="notification-number">6</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right dropdown-menu-md" aria-labelledby="navbar-notification-calendar">
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Meeting with Project Manager</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">Right now</span>
											</div>
										</a>
									</li>
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Sales Call</h6>
												<div class="notification-text">
													Nibh amet cras sit libero
												</div>
												<span class="notification-time">One hour from now</span>
											</div>
										</a>
									</li>
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Email CEO new expansion proposal</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">In 3 days</span>
											</div>
										</a>
									</li>
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Team building exercise</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">In one week</span>
											</div>
										</a>
									</li>
								</ul>
							</li> -->
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
									<!-- <li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-tag-alt-2 batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">New Order</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">Yesterday</span>
											</div>
										</a>
									</li>
									<li class="media">
										<a href="task-list.html">
											<i class="batch-icon batch-icon-pull batch-icon-xl d-flex mr-3"></i>
											<div class="media-body">
												<h6 class="mt-0 mb-1 notification-heading">Pull Request</h6>
												<div class="notification-text">
													Cras sit amet nibh libero
												</div>
												<span class="notification-time">3 day ago</span>
											</div>
										</a>
									</li> -->
								</ul>
							</li>
						</ul>
						@include('partials.userbar-admin')
					</div>
				</nav>
				<main class="main-content p-5" role="main">
					<div class="row">
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-primary bg-gradient text-center">
								<div class="card-body p-4">
									<!-- Accepts .invisible: Makes the items. Use this only when you want to have an animation called on it later -->
									<div class="tile-left">
										<i class="batch-icon batch-icon-user-alt batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">1,359</div>
										<div class="tile-description">Customers Online</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-secondary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-tag-alt-2 batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">$7,349.90</div>
										<div class="tile-description">Today's Sales</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-primary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-list batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">26</div>
										<div class="tile-description">Open Tickets</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-secondary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-star batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">476</div>
										<div class="tile-description">New Orders</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-6 col-xl-8 mb-5">
							<div class="card">
								<div class="card-header">
									Sales Overview
									<div class="header-btn-block">
										<span class="data-range dropdown">
											<a href="#" class="btn btn-primary dropdown-toggle" id="navbar-dropdown-sales-overview-header-button" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
												<i class="batch-icon batch-icon-calendar"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-sales-overview-header-button">
												<a class="dropdown-item" href="today">Today</a>
												<a class="dropdown-item" href="week">This Week</a>
												<a class="dropdown-item" href="month">This Month</a>
												<a class="dropdown-item active" href="year">This Year</a>
											</div>
										</span>
									</div>
								</div>
								<div class="card-body">
									
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-4 mb-5">
							<div class="card card-md">
								<div class="card-header">
									Traffic Sources
									<div class="header-btn-block">
										<span class="data-range dropdown">
											<a href="#" class="btn btn-primary dropdown-toggle" id="navbar-dropdown-traffic-sources-header-button" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
												<i class="batch-icon batch-icon-calendar"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right"  aria-labelledby="navbar-dropdown-traffic-sources-header-button">
												<a class="dropdown-item" href="today">Today</a>
												<a class="dropdown-item" href="week">This Week</a>
												<a class="dropdown-item" href="month">This Month</a>
												<a class="dropdown-item active" href="year">This Year</a>
											</div>
										</span>
									</div>
								</div>
								<div class="card-body text-center">
									<p class="text-left">Your top 5 traffic sources</p>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 mb-5">
							<div class="card card-sm bg-info">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-warning text-left">
											<i class="fa fa-twitter batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Twitter Followers</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">65,452</div>
										<div class="m-0">+72 Today</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4 mb-5">
							<div class="card card-sm">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-warning text-left">
											<i class="batch-icon batch-icon-star batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Reviews</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">7,842</div>
										<div class="m-0">
											<a href="#">Read More</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4 mb-5">
							<div class="card card-sm bg-danger">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-left">
											<i class="batch-icon batch-icon-reply batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Products Returned</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">231</div>
										<div class="m-0">-4% Today</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-md-6 col-lg-5 col-xl-3 mb-5">
							<div class="card card-md card-team-members">
								<div class="card-header">
									Team Members
								</div>
								<div class="card-media-list">
									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Johanna Quinn
											</div>
											<div class="subtext">jquinn897</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic-3.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Teal'c Jaffa
											</div>
											<div class="subtext">tealc</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-secondary float-right d-flex mr-3">
											<img src="assets/img/profile-pic-2.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Samantha Carter
											</div>
											<div class="subtext">samanthac</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-secondary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic-4.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												General Landry
											</div>
											<div class="subtext">glandry</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary float-right d-flex mr-3">
											<img src="assets/img/profile-pic-6.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Jacklin O'neil
											</div>
											<div class="subtext">jakjak</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Johanna Quinn
											</div>
											<div class="subtext">jquinn897</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic-3.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Teal'c Jaffa
											</div>
											<div class="subtext">tealc</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-secondary float-right d-flex mr-3">
											<img src="assets/img/profile-pic-2.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Samantha Carter
											</div>
											<div class="subtext">samanthac</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-secondary has-message float-right d-flex mr-3">
											<img src="assets/img/profile-pic-4.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												General Landry
											</div>
											<div class="subtext">glandry</div>
										</div>
									</div>

									<div class="media clickable" data-qp-link="profiles-member-profile.html">
										<div class="profile-picture bg-gradient bg-primary float-right d-flex mr-3">
											<img src="assets/img/profile-pic-6.jpg" width="44" height="44">
										</div>
										<div class="media-body">
											<div class="heading mt-1">
												Jacklin O'neil
											</div>
											<div class="subtext">jakjak</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-7 col-xl-6 mb-5">
							<div class="card card-md card-customer-location">
								<div class="card-header">
									Customer Location
								</div>
								<div class="card-body">
									<div class="card-chart" data-chart-color-selected="#07a7e3">
										<div id="customer-location"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-xl-3 mb-5">
							<div class="row mb-4">
								<div class="col-sm-12">
									<div class="card card-sm bg-primary bg-gradient text-center">
										<div class="card-body">
											<i class="batch-icon batch-icon-database batch-icon-xxl"></i>
											<h6 class="mt-1">Database Load</h6>
											<div class="card-chart" data-chart-color-1="#FFFFFF" data-chart-color-2="#FFFFFF">
												<canvas id="database-load"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="card card-sm bg-secondary bg-gradient text-center">
										<div class="card-body">
											<div class="card-chart" data-chart-color-1="#FFFFFF" data-chart-color-2="#FFFFFF" data-chart-color-2="#FFFFFF">
												<canvas id="profit-loss"></canvas>
											</div>
											<h6>Profit/Loss (18 Months)</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<!--  -->
					<div class="row mb-4">
						<div class="col-md-12">
							<footer>
								Powered by God's Grace
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
			  src="http://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    
	<!-- Popper.js - Bootstrap tooltips -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<!-- Bootstrap core JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="js/mdb.min.js"></script>
	<!-- Velocity -->
	<!-- <script type="text/javascript" src="assets/plugins/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="assets/plugins/velocity/velocity.ui.min.js"></script> -->
	<!-- Custom Scrollbar -->
	<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
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
	<script type="text/javascript" src="js/admin.core.js"></script>
</body>
</html>
