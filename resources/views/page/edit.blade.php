@extends('layouts.app')

@section('page.css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
@endsection

@section('aside')
	@include('partials.page.writerPanel')
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

	@include('partials.image.modal')
	
@endsection


@section('page.script')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.7.1/remarkable.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js" integrity="sha256-0dCrNKhVyiX4bBpScyU5PT/iZpxzlxjn2oyaR7GQutE=" crossorigin="anonymous"></script>
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

	@include('partials.image.modal-script')
@endsection