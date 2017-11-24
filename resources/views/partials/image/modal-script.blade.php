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

		        	this.on("addedfile", function() { $('#uploadError').html(''); }); 
		        }
		};
</script>