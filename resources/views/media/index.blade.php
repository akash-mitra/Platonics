@extends('layouts.admin')

@section('page.css')
    
    
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.css" /> -->
    
    @include ('partials.media.dropzone-css')

@endsection

@section('aside')
	@include('partials.admin.menu', ['media' => true])
@endsection
 
@section('header')
	@include('partials.media.breadcrumb')
@endsection

@section('main')
	
	
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="float-left">
                <h3>Media</h3>
                <p>Total {{ $media->total() }} Media Files (Showing {{ $media->perPage() }} per page). </p>
            </div>
            
            
            <button class="btn btn-primary bg-gradient float-right {{ (Auth::user()->type === 'Registered'?'disabled':'') }}" data-toggle="modal" data-target="#mediaModalUpload">
                <i class="fa fa-upload"></i>&nbsp;
                Upload
            </button>
            <a href="{{ route('media-index') }}" class="btn btn-outline-secondary float-right" title="Reload the page"><i class="fas fa-sync"></i></a>
        </div>
    </div>
	
    
    <div class="row text-center text-lg-left">
        
            @foreach($media as $m)
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-5">
                    <div class="card">
                        
                        <a href="{{ $m->url }}" 
                            data-toggle="lightbox" 
                            data-gallery="example-gallery">
                                <img src="{{ $m->url }}" class="card-img-top">
                        </a>

                        <div class="card-body">
                            <h4 class="card-title">
                                {{ $m->size_kb }} KB 
                                @if($m->storage == "s3")
                                    <i class="fab fa-aws"></i> 
                                @else
                                    <i class="far fa-hdd"></i> 
                                @endif
                            </h4>
                            <p class="card-text">
                                Stored {{ ($m->created_at->diff(\Carbon\Carbon::now())->days < 1)? 'today': $m->created_at->diffForHumans(\Carbon\Carbon::now())}}                                
                                @if($m->storage == "s3")
                                    in Amazon Cloud.
                                @else
                                    in Local Disk.
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
                            
            @endforeach
    </div>
    
    
    <nav class="d-flex justify-content-center">
        {{ $media->links('vendor.pagination.bootstrap-4') }}
    </nav>

    <!-- modal window for uploading media -->
    @include('partials.media.modal')

@endsection

@section('page.script')

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js"></script>
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
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

</script> -->

@include ('partials.media.dropzone-js')

@endsection