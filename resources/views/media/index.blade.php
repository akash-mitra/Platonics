@extends('layouts.admin')

@section('page.css')
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.css" />
    
    @include ('partials.media.dropzone-css')

@endsection

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	@include('partials.admin.breadcrumb')
	
	<button class="btn btn-success pull-right mq15 {{ (Auth::user()->type === 'Registered'?'disabled':'') }}" data-toggle="modal" data-target="#mediaModalUpload">
		<i class="fa fa-upload"></i>&nbsp;
		Upload
    </button>

	<h3>Media</h3>
	
	<p>Total {{ $media->total() }} Media Files (Showing {{ $media->perPage() }} per page). </p>
	
    
    <div class="row text-center text-lg-left">
        
        @foreach($media as $m)
                    <a href="{{ $m->url }}" 
                        data-toggle="lightbox" 
                        data-gallery="example-gallery" 
                        class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <img src="{{ $m->url }}" class="img-fluid" style="max-height: 150px;">
                    </a>
        @endforeach

    </div>
    
    <nav class="d-flex justify-content-center">
        {{ $media->links('vendor.pagination.bootstrap-4') }}
    </nav>

    <!-- modal window for uploading media -->
    @include('partials.media.modal')

@endsection

@section('page.script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js"></script>
<script>

    var placeHolderImage = function (image, event)
    {
        image.onerror=null;
        image.src='http://placehold.it/400x300?text=Image+Loading+Failed';
        return true;
    }


    /** 
     * Uses http://ashleydw.github.io/lightbox/
     * Using version 5.2.0 as the latest version has number of bugs
     */
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

</script>

@include ('partials.media.dropzone-js')

@endsection