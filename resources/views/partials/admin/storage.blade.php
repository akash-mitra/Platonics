
<h6>Where will you keep your media files such as images?</h6>
<p>
	You can either keep them in this Local server, Or you can have Platonics automatically upload them in a cloud storage, such as AWS S3 Bucket.
</p>

<br>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#local" role="tab"><i class="fa fa-hdd-o"></i>&nbsp;Keep in Local Server</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#aws" role="tab"><i class="fa fa-amazon"></i>&nbsp;Upload to Amazon S3</a>
	</li>
</ul>

<!-- Tab panes -->

<div class="tab-content">
	<div class="tab-pane active" id="local" role="tabpanel">
		<br>
		
		<p>
			By default Platonics places all your media files in <code>/storage/media</code> directory. 
		</p>

		<div class="form-group">
				<label>Path</label>
				<input type="text" value="/storage/media" class="form-control" disabled>
		</div>
	</div>

	<div class="tab-pane" id="aws" role="tabpanel">
		<br>
			
			<p>
				AWS allows you to store all your static contents in S3 and render them directly or via CloudFront CDN. 
			</p>
			
				
			<div class="form-group">
				<label for="inputKey">API Key</label>
				<p class="small">
					We recommend you create a new user for this purpose. Remember to choose the AWS access type as 'Programming Access' and to associate the user with group that has write privilege in your S3 bucket. Copy and paste the API access key and secret below.
				</p>
				<input type="text" class="form-control" id="inputKey" name="key" placeholder="Paste your AWS API Key" value="{{ $storage->apiKey }}">
			</div>

			<div class="form-group">
				<label for="inputSecret">Secret</label>
				<input type="text" class="form-control" id="inputSecret" name="secret" placeholder="Paste your AWS API Secret" value="{{ $storage->apiSecret }}">
			</div>

			<div class="form-group">
				<label for="inputRegion">Region</label>
				<p class="small">
					You need to mention the region where your AWS S3 bucket is hosted. Full list of <a href="http://docs.aws.amazon.com/general/latest/gr/rande.html" target="_blank">AWS Regions</a> are available here.
				</p>
				<input type="text" class="form-control" id="inputRegion" name="region" placeholder="AWS Region (us-east-1)" value="{{ $storage->region }}">
			</div>


			<div class="form-group">
				<label for="inputBucket">Bucket</label>
				<input type="text" class="form-control" id="inputBucket" name="bucket" placeholder="Bucket Name" value="{{ $storage->bucket }}">
			</div>

			<input type="hidden" name="type" value="s3">

			<button type="button" id="btnSaveStorage" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		
	</div><!--// tab panel -->
</div><!--// tab content -->


<p>&nbsp;</p>
<p>&nbsp;</p>

