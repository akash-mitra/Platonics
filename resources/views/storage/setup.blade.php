@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="topline">
		@include('partials.admin.breadcrumb')
	</div>
	
	<h3>Storage Setup</h3>
	<p>
		This page allows you to setup the storage parameters of all static resources (e.g. Images).
	</p>
	
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#aws" role="tab"><i class="fa fa-amazon"></i>&nbsp;Amazon</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="aws" role="tabpanel">
			<br>
			<form method="post" action="{{route('storage-store')}}" id="frm-create">
				{{ csrf_field() }}
				<h4>Amazon Web Services</h4>
				<p>
					AWS allows you to store all your static contents in S3 and render them via CloudFront CDN. Provide your AWS account credentials below.
				</p>
				<p class="small">
					<i class="fa fa-info"></i>&nbsp;
					We recommend you create a new user for this purpose. Remember to choose the AWS access type as 'Programming Access' and to associate the user with group that has write privilege in your S3 bucket. Copy and paste the API access key and secret below.
				</p>
					
				<div class="form-group">
				    <label for="inputKey">API Key</label>
				    <input type="text" class="form-control" id="inputKey" name="key" placeholder="Paste your AWS API Key" value="{{ $storage->apiKey }}">
				</div>

				<div class="form-group">
				    <label for="inputSecret">Secret</label>
				    <input type="text" class="form-control" id="inputSecret" name="secret" placeholder="Paste your AWS API Secret" value="{{ $storage->apiSecret }}">
				</div>

				<div class="form-group">
				    <label for="inputRegion">Region</label>
				    <input type="text" class="form-control" id="inputRegion" name="region" placeholder="AWS Region (us-east-1)" value="{{ $storage->region }}">
				</div>

				<p class="small">
					<i class="fa fa-info"></i>&nbsp;
					You need to mention the region where your AWS S3 bucket is hosted. Full list of <a href="http://docs.aws.amazon.com/general/latest/gr/rande.html" target="_blank">AWS Regions</a> are available here.
				</p>

				<input type="hidden" name="type" value="aws">

				<button type="submit" class="btn btn-primary">Save</button>
			</form>
		</div><!--// tab panel -->
	</div><!--// tab content -->

	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
@endsection


@section('page.script')	
	<script>

	</script>
@endsection