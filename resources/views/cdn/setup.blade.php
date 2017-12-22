@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="topline">
		@include('partials.admin.breadcrumb')
	</div>
	
	<h3>Content Delivery (CDN) Setup</h3>
	<p>
		CDN is a system of distributed servers (network) that deliver Web content to a user, based on the geographic locations of the user.
	</p>
	
	
	
	<form method="post" action="{{route('cdn-config-store')}}" id="frm-create">
		{{ csrf_field() }}
		
		  <div class="form-group">
    		<label for="media-cdn">Media</label>
    		<input type="text" class="form-control" id="media-cdn" name="media-cdn" placeholder="https://media.cloudfront.net/" value="{{ $cdn->mediaCdnPath }}">
		  </div>
		  
		  <div class="form-group">
    		<label for="js-cdn">JavaScript</label>
    		<input type="text" class="form-control" id="js-cdn" name="js-cdn" placeholder="https://js.cloudfront.net/" value="{{ $cdn->jsCdnPath }}">
		  </div>
		  
		  <div class="form-group">
    		<label for="css-cdn">CSS</label>
    		<input type="text" class="form-control" id="css-cdn" name="css-cdn" placeholder="https://css.cloudfront.net/" value="{{ $cdn->cssCdnPath }}">
		  </div>
		  
		  <p>
			  You should map the above CDN URLs to the corresponding storage locations of your original contents.
		  </p>

		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	</form>

	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
@endsection


@section('page.script')	
	<script>

	</script>
@endsection