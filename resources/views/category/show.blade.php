@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; 
		</div>
		
		
		

		<h3>Articles</h3>
		<!-- <h5>
			List of all articles under this category
		</h5> -->
		<hr>
		@foreach($articles as $article)
			<h4>
				<a href="{{route('article-view', str_slug($article->id . ' ' . $article->title))}}">{{$article->title}}</a>
			</h4>
			<p>
				{{$article->intro}}
			</p>
			<hr>
		@endforeach		
	</div>
	
@endsection