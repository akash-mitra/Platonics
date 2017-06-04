@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			
			<a href="{{route('admin')}}">Admin</a> > 
			<a href="{{route('module-list')}}">Modules</a> >
		</div>
		<br>
		  <!-- Tab panes -->
		  <form method="post" action="{{route('module-update')}}" id="frm-update">
		  	{{ csrf_field() }}
		  	{{ method_field('patch') }}
		  	<input type="hidden" name="id" value="{{$module->id}}">
		  	<div class="form-group">
			    <label for="inputTitle">Module Name</label>
			    <input 
			    	type="text" 
			    	class="form-control custom-control" 
			    	id="inputTitle" 
			    	placeholder="Ad module, Banner module..."
			    	name="name" 
			    	data-validation='required'
			    	value="{{$module->name}}"
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
			    	data-validation='required'>{{$module->html}}</textarea>
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
			if (validate('#frm-update')) 
				$('#frm-update').submit();
		});
	</script>
@endsection