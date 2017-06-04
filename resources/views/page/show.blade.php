@extends('layouts.app')

@section('aside')
	<div class="p30">
		<h4>Related </h4>
		<p>
			This is some related article on this topic
			<?php echo BladeHelper::loadModule("testdcdc");  ?>
		</p>
	</div>
@endsection

@section('main')
<div class="p30">
	<!-- <div class="topline">
		Home > $category > Settings
	</div> -->
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
</div>

@endsection