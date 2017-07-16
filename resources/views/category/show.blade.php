@extends('layouts.app')

@section('aside')
	@include('partials.category.menu')
@endsection

@section('main')

	@include('partials.breadcrumb', ['content' => $category])

	<h3>{{$category->name}}</h3>
	<p>
		{{ $category->description }}
	</p>
	<hr>

	@if($category->hasSubCategories())
		<h4>Sub-categories</h4>
		<p>
			This category also contains following sub-categories
		</p>
		<ol>
			@foreach($category->subcategories as $c)
				<li><a href="{{ $c->getUrlAttribute() }}">{{ $c->name }}</a></li>
			@endforeach
		</ol>
		<hr>
	@endif
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

	@if(count($pages) === 0)
		<p>
			<i class="fa fa-times"></i>&nbsp;No content available in this category
		</p>
	@endif

	<p>&nbsp;</p>
@endsection