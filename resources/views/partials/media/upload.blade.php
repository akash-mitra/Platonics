<p>
	Click below (or simply drag and drop file below) to upload to the server
</p>

<p id="uploadError"></p>



<form method="post" action="{{ route('media-store') }}" id="dropzoneUploader" class="dropzone" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="fallback">
		<input name="file" type="file" multiple />
	</div>
</form>



<small>
	File upload starts automatically after you choose or drag and drop new media above. 
</small>