@extends('layouts.admin')

@section('page.css')
    @include ('partials.media.dropzone-css')
	
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@5.23.0/dist/css/themes/beagle.min.css" type="text/css" media="screen">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor-tables@0.6.1/dist/css/medium-editor-tables.min.css" type="text/css" media="screen">

	<style>
		.unselectable {
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
	</style>
@endsection

@section('aside')
	
	@include('partials.page.sidemenu')

@endsection

@section('header')
	@include('partials.page.breadcrumb')
@endsection

@section('main')
	
	@include('partials.page.form')

	@include('partials.media.modal', ["withGallery" => true])

@endsection


@section('page.script')
	
	<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/medium-editor-tables@0.6.1/dist/js/medium-editor-tables.min.js"></script>
	
	<script>

		/**
		 * This section contains medium editor invocation related codes
		 */

		var title = new MediumEditor('#pageTitle', {
			toolbar: false,  // don't want any formatting capability
			paste: { cleanPastedHTML: true, forcePlainText: true },
			placeholder: { text: 'Article Heading...' }
		});


		var intro = new MediumEditor('#pageSummary', {
			toolbar: false,  // don't want any formatting capability
			paste: { cleanPastedHTML: true, forcePlainText: true },
			placeholder: { text: 'Provide a short summary (3-5 lines)..' }
		});

		var meBody = new MediumEditor('#pageBody', {
			delay: 1000,
			buttonLabels: 'fontawesome',
			toolbar: {
				buttons: ['bold', 'italic', 'underline', 'strikethrough', 'anchor', 'h2', 'h3', 'quote', 'table'],
			},
			paste: { cleanPastedHTML: true },
			anchorPreview: { hideDelay: 300 },
			placeholder: { text: 'Compose an epic today...' },
			extensions: {
      			table: new MediumEditorTable()
    		}
		});

	</script>

	<script>

		// Closes the current page and brings back to page index
		$('#btnClose').click (function () {
			location.href= "{{route('page-index')}}";
		});

		var pageId = "{{ $page->id }}";

		/**
		 * Actually submits the form with the data taken from content editables
		 */
		var saveContents = function () {
			
			var btn = $(this);
			
			var data = {
				category_id: $('#inputCat').val(),
				title: $('#pageTitle').text(),      // we do not want to capture any HTML, only text
				intro: $('#pageSummary').text(),    // we do not want to capture any HTML, only text
				markup: meBody.getContent(),        // we want to capture the HTML
				id: pageId
			}

			// console.log(data);

			makeAjaxRequest ({
				method: "post",
				data: data,
				to: "{{route('page-save')}}",
				before: function () {
					btn.addClass('disabled').html('<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;Saving...');
				},
				success: function (data) {
					if (typeof (data) !== 'undefined' && ! isNaN(data) && parseInt(data) > 0) {
						btn.removeClass('disabled').html('<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;Save');;
						pageId = parseInt(data);
					}
					else {
						showError("Could not obtain id from the returned data [" + data + "]")
					}
				},
				error: function (data) {
					showError("Something went wrong. Failed to save.")
				}
			})
		}

		enableTools = function () {
			console.log('yes')
			$('#btn-add-image').removeClass('disabled');
		}

		disableTools = function () {
			console.log('no')
			$('#btn-add-image').addClass('disabled');
		}


		$(document).ready(function () {	
			//make sure the category select list is prepopulated
			populateSelect ('#inputCat', '{{route("api-categories")}}', {"key": "record", "value":"label"}, '{{$page->category_id}}');

			// add one additional record for blank category "--"
			$('#inputCat').append($('<option>', {
			    value: '',
				text: 'Uncategorized',
				@if(empty($page->parent_id))	
					selected: true
				@endif
			}))

			// associate the event handlers
			$('#btnSave').click (saveContents)

			// remove the initial disabled class from the add media button
			$('#pageBody').focus (function () {
				$('#btn-add-image').removeClass('disabled');
			})
			
			$('#btn-add-image').click (function (){
				if (! $(this).hasClass('disabled')) { $('#mediaModalUpload').modal() }
			})
			
		})

	</script>

	@include ('partials.media.dropzone-js')

	<script>


		// Handy function to insert an image from the image URL in the Full Text portion
		var insertImageAtSelectionIn = function (imageUrl, elementId) {
			var imageNode, sel, range;

			imageNode = document.createElement('img');
			imageNode.src = imageUrl;
			imageNode.style.cssText = "max-width: 100%";

			if (window.getSelection) { // all browsers except IE < 9
				
				sel = window.getSelection();	
				if (document.getElementById(elementId).contains (sel.anchorNode) === false) return -1;
				range = sel.getRangeAt(0);
				range.deleteContents();
				range.insertNode(imageNode);
				
				// just remove if there is any placeholder text
				document.getElementById(elementId).classList.remove('medium-editor-placeholder');
			} 
			else if (document.selection && document.selection.createRange) {
				document.selection.createRange().insertNode(imageNode)
			} else {
				return -1; 
			}
		}


		var insertSelectedImage = function () {
			let imageUrl = selectedImage.attr('src');
			if (insertImageAtSelectionIn(imageUrl, 'pageBody') === -1) 
			{
				// trying to insert somewhere other than "Full Text" portion
				alert ("First click inside the page body (full text) to insert image");
			}
			$('#mediaModalUpload').modal('hide');
		}

		/**
		 * Following function adds the handler function 
		 * for the click even of "Add Image" button in media modal
		 */
		setImageClickHandler (insertSelectedImage)

	</script>

	
@endsection