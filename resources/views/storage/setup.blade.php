@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="topline">
		@include('partials.admin.breadcrumb')
	</div>
	
	<h3>Storage Service Provider</h3>
	<p>
		This page allows you to setup the parameters for Storage Services. 
		Storage is used to host all your original static contents, such as images and JavaScripts. 
		CDN Services (if configured), replicates these data to edge servers.
	</p>
	
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#local" role="tab"><i class="fa fa-hdd-o"></i>&nbsp;Local</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#aws" role="tab"><i class="fa fa-amazon"></i>&nbsp;Amazon S3</a>
		</li>
	</ul>

	<!-- Tab panes -->
	
	<div class="tab-content">
		<div class="tab-pane" id="local" role="tabpanel">
			<br>
			<h4>Local</h4>
			<p>
				If you choose not to use any third-party storage provider like Amazon S3 or DigitalOcean, 
				by deafult all your static contents will be placed in your own server.

				<div class="form-group">
					<label>Path</label>
					<p class="small">
						Information will be stored under below path
					</p>
				    <input type="text" value="/public" class="form-control" disabled>
				</div>
			</p>
		</div>
		<div class="tab-pane active" id="aws" role="tabpanel">
			<br>
			<form method="post" action="{{route('storage-store')}}" id="frm-create">
				{{ csrf_field() }}
				<h4>Amazon Web Services</h4>
				<p>
					AWS allows you to store all your static contents in S3 and render them via CloudFront CDN. Provide your AWS account credentials below.
				</p>
				
					
				<div class="form-group">
					<label for="inputKey">API Key</label>
					<p class="small">
						We recommend you create a new user for this purpose. Remember to choose the AWS access type as 'Programming Access' and to associate the user with group that has write privilege in your S3 bucket. Copy and paste the API access key and secret below.
					</p>
				    <input type="text" class="form-control" id="inputKey" name="key" placeholder="Paste your AWS API Key" value="{{ $storage->apiKey }}">
				</div>

				<div class="form-group">
				    <label for="inputSecret">Secret</label>
				    <input type="text" class="form-control" id="inputSecret" name="secret" placeholder="Paste your AWS API Secret" value="{{ $storage->apiSecret }}">
				</div>

				<div class="form-group">
					<label for="inputRegion">Region</label>
					<p class="small">
						You need to mention the region where your AWS S3 bucket is hosted. Full list of <a href="http://docs.aws.amazon.com/general/latest/gr/rande.html" target="_blank">AWS Regions</a> are available here.
					</p>
				    <input type="text" class="form-control" id="inputRegion" name="region" placeholder="AWS Region (us-east-1)" value="{{ $storage->region }}">
				</div>


				<div class="form-group">
				    <label for="inputBucket">Bucket</label>
				    <input type="text" class="form-control" id="inputBucket" name="bucket" placeholder="Bucket Name" value="{{ $storage->bucket }}">
				</div>

				<input type="hidden" name="type" value="s3">

				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
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