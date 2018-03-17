@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["comments" => true])
@endsection

 
@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Comments'])
@endsection

@section('main')

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="float-left">
                <h3>Comments</h3>
                <p>Moderation screen for Blog comments</p>
            </div>
        </div>
    </div>
        
    @foreach($comments as $c)
        @php
            $currentPage=(isset($c->page->id)? $c->page->id : 0)
        @endphp
        
        @if(! isset($previousPage) || $previousPage != $currentPage)

            @if($loop->index > 0)
            </div>
                </div>
                    </div>  
            @endif

            <div class="row mb-5">
                <div class="col-md-12">    
                    <div class="card">
                        <div class="card-header">
                            <small>Latest comments on page</small><br>
                            <h4>{{isset($c->page->title)? $c->page->title:'Page no longer exists'}}</h4>
                        </div>
                        
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img class="avatar" src="{{ $c->user->defaultProvider()->avatar }}" alt="user profile pic" align="left" style="margin: 0 15px 15px; ">
                        <strong>{{ $c->user->name }} </strong>
                        <br>
                        {{ $c->updated_at->diffForHumans() }}
                </div>
                <div class="col-md-9">
                    <p class="card-text">      
                        {{$c->body}}
                    </p>
                </div>
            </div>
        </div>    
        <div class="card-footer border-top-0 border-bottom">
            <span>
                    <i class="far fa-arrow-alt-circle-up"></i>
                    Commented on {{ $c->updated_at->toRfc850String() }}
            </span>
            <a class="float-right" href="{{ route('comment-delete', $c->id) }}">
                <i class="far fa-trash-alt"></i>&nbsp;Delete
            </a>
        </div>        
        
        @php
            $previousPage=$currentPage
        @endphp
    @endforeach
    
    </div>
        </div>
            </div>
    
    <nav class="d-flex justify-content-center">
        {{ $comments->links('vendor.pagination.bootstrap-4') }}
    </nav>

@endsection

@section('page.script')
    
@endsection