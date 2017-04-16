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
		
		@foreach($pages as $page)
			@if($loop->index % 2 === 0)
				<div class="row">
			@endif
			<div class="col-md-6">
				<h4>
					<a href="{{route('page-view', [
						'categorySlug' => $category->slug,
						'page' => str_slug($page->id . ' ' . $page->title, '-'),
					])}}">{{$page->title}}</a>
				</h4>
				<p>
					{{$page->intro}}
				</p>
			</div>
			@if($loop->index % 2 === 1)
				</div>
			@endif
			
		@endforeach	
	</div>
	
@endsection