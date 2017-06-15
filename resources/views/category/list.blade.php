@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; Categories
		</div>
		
		
		<a href="{{route('category-create')}}" class="btn btn-success pull-right m15 {{ (Auth::user()->type === 'Admin'?'':'disabled') }}">
			<i class="fa fa-plus-square-o"></i>&nbsp;
			New Category
		</a>

		<h3>Category</h3>
		<h5>
			List of all categories
		</h5>
		<hr>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>#</th><th>Category</th><th>Parent Category</th><th>Description</th><th>Last Updated</th><th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
					<tr>
						<td>{{$category->id}}</td>
						<td>
							<a class="" href="{{route('category-view', $category->slug)}}">
							{{$category->name}}
							</a>
						</td>
						<td>
							@if($category->parent()->count() == 0)
								None
							@else
								{{ $category->parent->name }}
							@endif
						</td>
						<td>{{ substr(strip_tags($category->description), 0, 50) . (strlen($category->description)>50?"...":"") }}</td>
						<td>
							{{ $category->updated_at->diffForHumans()}}
						</td>
						<td>
							<a class="btn btn-sm btn-default {{ (Auth::user()->type === 'Admin'?'':'disabled') }}" href="{{route('category-edit', $category->id)}}">
								<i class="fa fa-pencil-square-o"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>		
	</div>
	
@endsection