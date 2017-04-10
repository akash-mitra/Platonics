@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> > 
			<a href="route('admin')">Admin</a> > Create new Category
		</div>
		<br>
		  <!-- Tab panes -->
		  <form method="post" action="{{route('category-store')}}" id="frm-create">
		  	{{ csrf_field() }}
		  	<div class="form-group">
			    <label for="inputTitle">Category Name</label>
			    <input 
			    	type="text" 
			    	class="form-control custom-control" 
			    	id="inputTitle" 
			    	placeholder="News or Sports..."
			    	name="head" 
			    	data-validation='required'
			    />
			</div>

			<div class="form-group">
			    <label for="inputUrl">URL Slug</label>
			    <input 
			    	type="text" 
			    	class="form-control custom-control" 
			    	id="inputUrl" 
			    	name="url" 
			    	data-validation='required' 
			    	readonly 
			    />
			</div>

			<div class="form-group">
			    <label for="inputCat">Select parent category</label>
			    <select 
			    	class="form-control custom-control" 
			    	id="inputCat" 
			    	name="cat">
			    </select>
			</div>

			<div class="form-group">
			    <label for="inputText">Category Description</label>
			    <textarea 
			    	class="form-control custom-control" 
			    	id="inputText" 
			    	placeholder="Assorted collection of articles on day's breaking news..."
			    	name="body"
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
		$(document).ready(function () {

			// populate the category selection options 
			populateSelect ('#inputCat', '{{route("api-categories")}}');

			// add one aadditional record for blank category "--"
			$('#inputCat').append($('<option>', {
			    value: '',
			    text: '--'
			}));
		});

		// This code generates the Slug as and when category
		// name is typed out
		$('#inputTitle').keyup(function () {
			let url = $('#inputTitle').val();
			$('#inputUrl').val(url.toLowerCase().replace(/ /g, '-')); 
		});

		// form submit
		$('#btn-submit').click (function () {
			if (validate('#frm-create')) 
				$('#frm-create').submit();
		});


	</script>
@endsection