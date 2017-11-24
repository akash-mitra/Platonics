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
		'headerText' => 'Create New Page'
	])
	
	<p>&nbsp;</p>

	@include('partials.page.navtab')
	
	<form method="post" action="{{route('page-store')}}" id="frm-create">
		@include('partials.page.form', [
			'page' => new App\Page
		])
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
			
			if (validate('#frm-create')) {
				console.log('submitting');
				$('#frm-create').submit();
			}
		});

		$(document).ready(function () {
			
			// invoke the markdown editor in the textarea
			new Editor (gebi("inputText"), gebi("preview"));

			// make sure the category select list is prepopulated
			populateSelect ('#inputCat', '{{route("api-categories")}}');

			// add one aadditional record for blank category "--"
			$('#inputCat').append($('<option>', {
			    value: '',
			    text: 'Uncategorized'
			}));
		});
	</script>

	@include('partials.image.modal-script')
@endsection