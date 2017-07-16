@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="topline">
		@include('partials.page.breadcrumb')
	</div>

	@include('partials.admin.header', [
		'headerText' => 'Edit Page'
	])

	<p>&nbsp;</p>

	@include('partials.page.navtab')

	<form method="post" action="{{route('page-store')}}" id="frm-create">
		{!! method_field('patch') !!}
		@include('partials.page.form')
	</form>
	 
	<form method="POST" action="{{route('page-delete', $page->id)}}" id="frm-delete">
		{{csrf_field()}}
	</form>
	
@endsection


@section('page.script')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.7.1/remarkable.min.js"></script>
	<script>

		$('#btn-close').click (function () {
			location.href= "{{route('page-index')}}";
		});
		
		$('#btn-submit').click (function () {
			if (validate('#frm-edit')) 
				$('#frm-edit').submit();
		});

		$('#btnDelPage').click (function () {
			if(confirm('Are you sure to delete this page?')) {
				$('#frm-delete').submit();
			}
		});

		$(document).ready(function () {

			new Editor (gebi("inputText"), gebi("preview"));

			populateSelect ('#inputCat', 
				'{{route("api-categories")}}',
				{"key": "record", "value":"label"},
				'{{$page->category_id}}');

			// if the parent category id is blank in the database
			// the same is represented as "--" in front-end	
			let blankChoice = false;
			@if(empty($page->parent_id))	
				blankChoice = true;
			@endif

			// add one aadditional record for blank category "--"
			$('#inputCat').append($('<option>', {
				    value: '',
				    text: 'Uncategorized',
				    selected: blankChoice
			}));
		});

	</script>
@endsection