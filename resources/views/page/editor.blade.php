@extends('layouts.admin')

@section('page.css')
    
    @include ('partials.media.dropzone-css')
	
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@5.23.0/dist/css/themes/beagle.min.css" type="text/css" media="screen">

@endsection

@section('aside')
	@include('partials.page.writerPanel')
@endsection

@section('main')
	
	<div>
		@include('partials.page.breadcrumb')
	</div>
	
	@include('partials.page.form')


	@include('partials.media.modal', ["withGallery" => true])

@endsection


@section('page.script')
	
	<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>

	<script>
		var title = new MediumEditor('#pageTitle', {
			toolbar: false,
			paste: { cleanPastedHTML: true, forcePlainText: true },
			placeholder: { text: 'Article Heading...' }
		});


		var intro = new MediumEditor('#pageSummary', {
			delay: 1000,
			toolbar: {
				buttons: ['bold', 'italic', 'underline', 'strikethrough', 'anchor'],
			},
			paste: { cleanPastedHTML: true, forcePlainText: true },
			placeholder: { text: 'Provide a short summary (3-5 lines)..' }
		});

		var body = new MediumEditor('#pageBody', {
			delay: 1000,
			toolbar: {
				buttons: ['bold', 'italic', 'underline', 'strikethrough', 'image', 'anchor', 'h2', 'h3', 'quote'],
			},
			paste: { cleanPastedHTML: true },
			anchorPreview: { hideDelay: 300 },
			placeholder: { text: 'Compose an epic today...' }
		});

	</script>

	<script>
		// Closes the current page and brings back to page index
		$('#btnClose').click (function () {
			location.href= "{{route('page-index')}}";
		});


		// // Validates and if validated submits the form to create new page
		// $('#btn-submit').click (function () {
		// 	if (validate('#frm-create')) {
		// 		$('#frm-create').submit();
		// 	}
		// });

		var pageId = "{{ $page->id }}";
		
		var saveContents = function () {

			var data = {
				title: title.getContent(),
				intro: intro.getContent(),
				category_id: $('#inputCat').val(),
				markup: body.getContent(),
				id: pageId
			}

			makeAjaxRequest ({
				method: "post",
				data: data,
				to: "{{route('page-save')}}",
				success: function (data) {
					if (typeof (data) !== 'undefined' && ! isNaN(data) && parseInt(data) > 0) {
						pageId = parseInt(data);
						ajaxSuccess (data);
					}
					else {
						ajaxError({"responseText": "Could not obtain id from the returned data [" + data + "]"})
					}
				}
			})
		}


		var submitForm = function (url, data)
		{
			// create a form
			var form = document.createElement ("form");
			form.setAttribute ('method', "post");
			form.setAttribute ('action', url);


		}

		$(document).ready(function () 
		{	
			//make sure the category select list is prepopulated
			populateSelect ('#inputCat', 
				'{{route("api-categories")}}',
				{"key": "record", "value":"label"},
				'{{$page->category_id}}');

			//add one additional record for blank category "--"
			$('#inputCat').append($('<option>', {
			    value: '',
				text: 'Uncategorized',
				@if(empty($page->parent_id))	
					selected: true
				@endif
			}))

			$('#btnSave').click (saveContents);
		})
	</script>

	@include ('partials.media.dropzone-js')
@endsection