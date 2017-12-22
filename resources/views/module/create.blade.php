@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> > 
			<a href="route('admin')">Admin</a> > Create Module
		</div>
		<br>
		  <!-- Tab panes -->
		  <form method="post" action="{{route('module-store')}}" id="frm-create">
		  	{{ csrf_field() }}
		  	<div class="form-group">
			    <label for="inputTitle">Module Name</label>
			    <input 
			    	type="text" 
			    	class="form-control custom-control" 
			    	id="inputTitle" 
			    	placeholder="Ad module, Banner module..."
			    	name="name" 
			    	data-validation='required'
			    />
			</div>

			<div class="form-group">
			    <label for="inputText">Module HTML</label>
			    <textarea 
			    	class="form-control custom-control" 
			    	id="inputText" 
			    	placeholder="<p>Awesome Ad...</p>"
			    	name="html"
			    	style="height: 150px" 
			    	data-validation='required'></textarea>
			</div>
		</form>
		<button id="btn-submit" class="btn btn-success pull-right">Save</button>  
		<p>&nbsp;</p>
	</div>
	
@endsection


@section('page.script')
	<script>
		// form submit
		$('#btn-submit').click (function () {
			if (validate('#frm-create')) 
				$('#frm-create').submit();
		});
	</script>
@endsection