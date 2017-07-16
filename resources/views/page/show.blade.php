@extends('layouts.app')

@section('aside')
	<h4>Related </h4>
	<p>
		These are some related articles on this topic
	</p>
@endsection

@section('main')

	@include('partials.breadcrumb', ['content' => $page])
	
	<h3>
		{{$page->title}}
	</h3>

	<div class="article-info">
		<span class="small pull-left">
			Written by <a href="{{$page->author->url}}">{{$page->author->name}}</a>
		</span>
		<span class="small pull-right">
			Last updated {{$page->updated_at->diffForHumans()}}
		</span>
	</div>

	<p class="lead">
		{!! $page->intro !!}
	</p>
	<div class="article-body">
		{!! $page->markup !!}
	</div>

	<div class="article-footer">
		@include('partials.comment.show')
		
		<div class="row">
			<div class="col-md-6">
				<h3>We are a community</h3>
				<p>
					Join us and get benefitted
				</p>
			</div>
			<div class="col-md-6">
				<h3>Read other articles</h3>
				<p>
					Here are a few articles you may be interested on:
				</p>
			</div>
		</div>
	</div>
<!-- end of article footer -->

@endsection

@section('page.script')
	@include('partials.comment.scripts')
@endsection