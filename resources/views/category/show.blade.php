@extends('layouts.app')

@section('aside')
	@include('partials.category.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; 
		</div>

		<h3>{{$category->name}}</h3>
		<p>
			{{$category->description}}
		</p>
		<hr>
		
		@foreach($articles as $article)
			@if($loop->index % 2 === 0)
				<div class="row">
			@endif
			<div class="col-md-6">
				<h4>
					<a href="{{route('article-view', str_slug($article->id . ' ' . $article->title))}}">{{$article->title}}</a>
				</h4>
				<p>
					{{$article->intro}}
				</p>
			</div>
			@if($loop->index % 2 === 1)
				</div>
			@endif
			
		@endforeach	
	</div>
	
@endsection