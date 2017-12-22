<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js" integrity="sha256-0dCrNKhVyiX4bBpScyU5PT/iZpxzlxjn2oyaR7GQutE=" crossorigin="anonymous"></script>

<script>
Dropzone.options.dropzoneUploader = {
		        maxFilesize: 2, // MB
		        init: function() {
		        	this.on("error", function(file, errorMessage) { 
		        		let err = '<div class="alert alert-danger">' 
		        			+ errorMessage.message 
		        			+ '</div>';
		        		$('#uploadError').html($('#uploadError').html() + err);
		        		this.defaultOptions.error(file, 'Error ' + errorMessage.code + ' has occurred');  
		        	});
		        	this.on("addedfile", function() { $('#uploadError').html('') })
		        }
		}
</script>

<script>

		// gobal variables
		let gAddButton = false;
		let isGalleryPopulated = false;

		/*
		 * Populates the gallery
 		 */
		var populateGallery = function ()
		{
			if (isGalleryPopulated) return;
			console.log('populating gallery ...')
			
			let url = "{{ route('api-media') }}";
			$('#media-list').html ('<div class="col-md-12"><i class="fa fa-refresh fa-spin"></i> Retrieving images from server. Please wait...</div>');
			
			$.ajax(url, {
				method: "GET",
				success: fillGalleryWithImages,
				error: showErrorMessage
			})
		}



		/*
		 * Actually populates the media gallery with the data
		 * from JSON response.
		 */
		var fillGalleryWithImages = function (response) { 
			
			let i = 0, html = '';
			let items = response.data;
			let count = items.length;
			let selectedImage = null;

			if (count === 0) {
				$('#media-list').html ('<div class="col-md-12">No media found</div>')
			}
			else {
				for (i = 0; i < count; i++) {
					let img = '<img src="' + items[i].path + '" class="img-fluid media-thumbnail">';
					let span = '<span class="media-info">' + items[i].storage + ' • ' + items[i].size_in_kb + ' kB</span>';
					html += '<div class="col-lg-2 col-md-3 col-sm-4 mb-4">' + img + span+ '</div>';
				}
				$('#media-list').html (html)
			}

			$('#mediaModalUpload').data('bs.modal').handleUpdate()
			isGalleryPopulated = true
		}



		/*
		 * Shows an error message if AJAX query to get media data fails.
		 */
		var showErrorMessage = function (response) {
			console.log(response);
			let html = '<div class="col-md-12"><div class="alert alert-danger" role="alert">' + response.responseText + '</div></div>';
			$('#media-list').html (html)
		}



		/*
		 * when image in media gallery is clicked, select
		 * the thumbnail and activate the "Use This" button
		 */ 
		var selectMediaThumbnail = function () {
			
			selectedImage = $(this)
			
			$('.media-thumbnail').removeClass ('media-thumbnail-selected')
			selectedImage.addClass('media-thumbnail-selected')

			// add "Use This" button if not already present
			if (gAddButton === false) {
				gAddButton = $('<button id="use-this" type="button" class="btn btn-primary">Use this</button>')
				gAddButton.appendTo ('.modal-footer')
			}
		}


	
		
		var insertSelectedImage = function () {
			insertAtCursor (document.getElementById('inputText'), selectedImage.attr('src'));
		}

		/*
		 * Attach the gallery invocation function with the Gallery link of the nav
		 */
		$(document).ready(function () {

			// handles click on media gallery images
			$('#media-list').on('click', '.media-thumbnail', selectMediaThumbnail)

			// populates the media gallery if gallery is present
			$('#mediaModalUpload').on('show.bs.modal', function (e) {
  				if ( $('#media-list').length ) { 
					  populateGallery ()
				}
			})

			// remove previous selections, etc. when closing the modal
			$('#mediaModalUpload').on('hidden.bs.modal', _cleanUpGallerySelections)

			$('.modal-footer').on ('click', '#use-this', insertSelectedImage)

			$('#nav-upload-tab').click (_cleanUpGallerySelections)
		})


		var _cleanUpGallerySelections = function () 
		{
			if (gAddButton) {
				gAddButton.remove()
				gAddButton = false
			}
			$('.media-thumbnail').removeClass ('media-thumbnail-selected')
		}
	

		
</script>

