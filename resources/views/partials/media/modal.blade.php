<div class="modal fade bd-example-modal-lg" id="mediaModalUpload" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Media</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <nav class="nav nav-tabs" id="myTab" role="tablist">

          @if(isset($withGallery))
            <a class="nav-item nav-link active" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Gallery</a>  
            <a class="nav-item nav-link" id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="true">Upload</a>
          @else
            <a class="nav-item nav-link active" id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="true">Upload</a>
          @endif

        </nav>


        <div class="tab-content" id="nav-tabContent">
          

          @if(isset($withGallery))

            <div class="tab-pane fade show active" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab" style="max-height: calc(100vh - 300px); overflow:scroll">
              <br>
              <div id="media-list" class="row text-center text-lg-left"></div>
            </div>
            <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
              <br>
              @include('partials.media.upload')
            </div>
          @else
            <div class="tab-pane fade show active" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
              <br>
              @include('partials.media.upload')
            </div>
          @endif

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>