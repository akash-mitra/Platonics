<div class="modal fade bd-example-modal-lg" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Add Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#album" role="tab">Choose from Album</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#upload" role="tab">Upload New Image</a>
          </li>
          
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane" id="upload" role="tabpanel">
              @include('partials.image.upload')
          </div>
          <div class="tab-pane active" id="album" role="tabpanel">
              @include('partials.image.album')
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary disabled">Add Image</button>
      </div>
    </div>
  </div>
</div>