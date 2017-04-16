@extends('layouts.chronicle')

<!-- @section('aside')
	
@endsection -->

@section('main')
	<style>
		.homepage h1 {
			margin: 0;
			padding: 50px 0 20px;
		}
		.homepage h3 {
			margin: 0;
			padding: 10px 50px;
		}
		.banner {
			float:left;
		}

		.tiler  {
			text-align: center;
			float:left;
			padding-top: 75px;
			padding-bottom: 75px;
		}

		.bg-offwhite {
			background-color: #f8f8f8;
		}
		.tile h3 {
			color: #21aa8f;
		}
		.tile i {
			color: #626d7b;
		}

		.explanation {	
			float:left;
		}

		.explanation .symbol {
			color: #626d7b;
			font-size: 2.6rem;
			font-weight: 500;
			text-transform: none;
			letter-spacing: -.025em;
		}

		.buyplan {
			float:left;
		}
	</style>
	<div class="homepage">

		<!-- 
		The first section is the banner. The banner section contains
		a headline and a subheader line, followed by call-to-action buttons.
		This section can also contain an image (the main page blog image)
		-->
		<div class ="banner" style="background-color:white; text-align: center;">
			<h1>It's Kinda Like Netflix for Your Career!</h1>
			<h3>
			Learn practical, modern web development, through expert screencasts. Most video tutorials are boring. These aren't. Ready to binge?
			</h3>
			<p></p>
			<a class="btn btn-lg btn-success">Sign Up</a>
			<a class="btn btn-lg btn-default">Know More</a>
			<p></p>
			<img src="/img/blogimage.png" style="width: 45%; max-width: 550px; min-width: 300px">
		</div>

		<!--//
		Next section is the tile section that contains a few main features in
		tile shape. the texts in these tiles are all center positioned and the
		tile contains an image, a header and an explanatory paragraph
		//-->
		<div class="tiler p30 bg-offwhite">
			<div class="col-md-3">
				<div class="tile">
					<i class="fa fa-snowflake-o fa-fw fa-4x"></i>&nbsp;
					<h3>Fast data transfer</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="tile">
					<i class="fa fa-file-o fa-fw fa-4x"></i>&nbsp;
					<h3>Reliable Data Delivery</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="tile">
					<i class="fa fa-handshake-o fa-fw fa-4x"></i>&nbsp;
					<h3>Trustworthy network</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="tile">
					<i class="fa fa-bookmark-o fa-fw fa-4x"></i>&nbsp;
					<h3>50% cheaper bulk price</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
		</div>


		<!--//
		This is the feature explanation section. In this section, couple of 
		main features are explained with details. This section contains one
		headline (or image) and the explanatory texts. The headdline will be
		usually placed horizontally with the texts
		//-->
		<div class="explanation p30 bg-white">

			<!--//
			The first row - headline and explanation. Headline/image left aligned
			//-->
			<div class="row pv50">
				<div class="col-md-3 col-md-offset-2">
					<div class="symbol">
						The most concise screencasts for the working developer, updated daily.
					</div>	
				</div>
				<div class="col-md-5">
					<p class="">
						The secret sauce for Laracasts is a simple one. No slides. No scripts. Just Sublime. As a visual learner, I'd often find myself watching video tutorials and falling asleep. There's only so many diagrams and bullet lists that one person can get through!
					</p>
				</div>
			</div>
			

			<hr style="border: 2px dashed #21aa8f; width: 66%; height: 0">
			<!--//
			The second row - headline and explanation. Headline or image right aligned
			//-->
			<div class="row pv50">
				<div class="col-md-5 col-md-offset-2">
					<p class="">
						The secret sauce for Laracasts is a simple one. No slides. No scripts. Just Sublime. As a visual learner, I'd often find myself watching video tutorials and falling asleep. There's only so many diagrams and bullet lists that one person can get through!
					</p>
				</div>
				<div class="col-md-3">
					<div class="symbol">
						The most concise screencasts for the working developer, updated daily.
					</div>	
				</div>
			</div><!-- row -->
		</div><!-- explanation -->


		<!--// 
		some other centered text place that can be used for feature listing 
		or plan listing
		//-->

		<div class ="banner" style="background-color:white; text-align: center;">
			<img src="/img/blogimage.png" style="width: 45%; max-width: 550px; min-width: 300px">
			<h1>Choose a plan that fits your needs</h1>
			<h4 class="col-md-8 col-md-offset-2">
			Joining takes less than a minute, and, if your peers are correct, is a pretty dang good decision. If you're still on the fence, we have a plan called “monthly” - and it’s not like the gym. Seriously - you can cancel in five seconds, if this isn't for you.
			</h4>
			<p class="col-md-12">&nbsp;</p>
			<div class="col-md-2 col-md-offset-2">
				<div class="til1e bg-offwhite">
					
					<h3>Fast data transfer</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
			<div class="col-md-2 col-md-offset-1">
				<div class="til1e bg-offwhite">
					
					<h3>Reliable Data Delivery</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>
			<div class="col-md-2 col-md-offset-1">
				<div class="tile1 bg-offwhite">
					
					<h3>Trustworthy network</h3>
					<p>Take the advantage of fast data transfer</p>
				</div>
			</div>

			
		</div>

	</div>
	
@endsection