@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="topline">
		@include('partials.admin.breadcrumb')
	</div>
	
	<h3>Image Setup</h3>
	<p>
		This page allows you to setup the configuration parameters related to static image assets of this website.
	</p>
	
	<br>
	
	<form method="post" action="{{route('image-store')}}" id="frm-create">
		{{ csrf_field() }}
		
		<div class="form-group">
		    	<label for="selImageStore">Image Storage Provider</label>
		    	<select class="form-control" id="selImageStore" name="storageProvider">
		    		<option value="">select</option>
				<option 
					value="aws" 
					@if($image->storageProvider === 'aws') selected @endif>
						AWS - Simple Storage Services (s3)
				</option>
				<option 
					value="local"
					@if($image->storageProvider === 'local') selected @endif>
						Local Server
				</option>
			</select>
		</div>

		<p class="small">
			<i class="fa fa-info"></i>&nbsp;
			You must configure the storages separately under <a href="{{ route('storage') }}">Storage</a> menu.
		</p>

		<div class="form-group">
		    <label for="inputLocation">Image Location</label>
		    <input type="text" class="form-control" id="inputLocation" name="baseLocation" placeholder="/img/" value="{{ $image->baseLocation }}">
		</div>

		<p class="small">
			<i class="fa fa-info"></i>&nbsp;
			For local server, this is a relative path (e.g., /my/image/files/). For Amazon Web Services, you may specify S3 bucket name here.
		</p>

		<button type="submit" class="btn btn-primary">Save</button>
	</form>

	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
@endsection


@section('page.script')	
	<script>

	</script>
@endsection