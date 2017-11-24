<br>
<p>
	Click or simply drag and drop file below to upload to the server
	<br>
	<small><i class="fa fa-info"></i>&nbsp;File upload starts immediately after you choose or drag and drop new file below. Once upload finishes, click on the "Add Image" button below to add the image to your page.</small>
</p>

<p id="uploadError"></p>

<form method="post" action="{{ route('image-store') }}" id="dropzoneUploader" class="dropzone" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="fallback">
		<input name="file" type="file" multiple />
	</div>
</form>

