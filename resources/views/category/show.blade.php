@extends('layouts.app')


@section('title')
	{{$category->name}}
@endsection

@section('meta')
	{{ count($pages) }} article(s) available under this category
@endsection

@section('lead')
	{{ $category->description }}
@endsection

@section('body')
	
	@if(count($category->subcategories))
		<div id="category-subcategory" class="p-3 bg-light">
			<h4>Sub-categories</h4>
			<p>
				This category also contains following sub-categories
			</p>
			
			@foreach($category->subcategories as $c)
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">{{ $c->name }}</h5>
						<p class="card-text">{{$c->description}}</p>
						<a class="card-link" href="{{ $c->getUrlAttribute() }}">Read More</a>
					</div>
				</div>
			@endforeach
			
		</div>
	@endif


	<div id="category-page" class="my-1">
		<!-- <h4 class="border-bottom pb-1">Pages</h4> -->

		@foreach($pages as $page)
			@if($loop->index % 2 === 0)
				@php $rowOpen=1 @endphp
				<div class="row py-1">
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
				@php $rowOpen=0 @endphp
				</div>
			@endif
		@endforeach

		@if(isset($rowOpen) && $rowOpen==1)
				</div>
		@endif

		

		@if(count($pages) === 0)
			<p class="border border-info rounded my-3 p-3">
				<i class="fa fa-times"></i>&nbsp;No article page available in this category.
			</p>
		@endif

	</div>

@endsection