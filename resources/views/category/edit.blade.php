@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt;
			<a href="{{route('admin')}}">Admin</a> &gt;
			<a href="{{route('category-list')}}">Categories</a> &gt;
		</div>
		<br>
		  
		  <form method="post" action="{{route('category-save')}}" id="frm-edit">
		  	{{ csrf_field() }}
		  	{{ method_field('patch') }}
		  	<input type="hidden" name="id" value="{{$category->id}}">
		  	<div class="form-group">
			    <label for="inputTitle">Category Name</label>
			    <input 
			    	type="text" 
			    	class="form-control custom-control" 
			    	id="inputTitle" 
			    	placeholder="News or Sports..."
			    	name="head" 
			    	value="{{$category->name}}"
			    	data-validation='required'
			    />
			</div>

			<div class="form-group">
			    <label for="inputText">Category Description</label>
			    <textarea 
			    	class="form-control custom-control" 
			    	id="inputText" 
			    	placeholder="Assorted collection of articles on day's breaking news..."
			    	name="body"
			    	style="height: 150px" 
			    	data-validation='required'>{!! $category->description !!}</textarea>
			</div>
		</form>
		<p>
		  <button id="btn-submit" class="btn btn-success pull-right">Update</button>  
		  
		  <button id="btn-close" class="btn btn-default pull-left">Close</button>  

		 </p>
		<p>&nbsp;</p>
	</div>
	
@endsection


@section('page.script')
	<script>
		$('#btn-submit').click (function () {
			if (validate('#frm-edit')) 
				$('#frm-edit').submit();
		});

		$('#btn-close').click (function () {
			location.href = "{{route('category-list')}}";
		});

	</script>
@endsection