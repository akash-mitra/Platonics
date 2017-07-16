@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
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

@endsection


@section('page.script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.7.1/remarkable.min.js"></script>
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
@endsection