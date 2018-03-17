@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('header')
	@include('partials.category.breadcrumb')
@endsection

@section('main')

	<div class="row">
		<div class="col-md-12">
			@include('partials.admin.header', [
				'headerText' => 'Create New Category'
			])
		</div>
	</div>

	<div class="row mb-5">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form method="post" action="{{route('category-store')}}" id="frm-create">
						@include('partials.category.form', [
							'category' => new App\Category
						])
					</form>
				</div>
			</div>
		</div>
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

		$('#btn-close').click (function () {
			location.href= "{{route('category-index')}}";
		});

	</script>
@endsection