@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="topline">
		@include('partials.category.breadcrumb')
	</div>
	
	@include('partials.admin.header', [
		'headerText' => 'Create New Category'
	])
	
	<p>&nbsp;</p>

	<form method="post" action="{{route('category-save')}}" id="frm-edit">
	  	@include('partials.category.form', [
	  		'category' => new App\Category
	  	])
	</form>
	

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

		$('#btn-close').click (function () {
			location.href= "{{route('category-index')}}";
		});

	</script>
@endsection