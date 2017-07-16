@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	@include('partials.admin.breadcrumb')

	<a href="{{route('category-create')}}" class="btn btn-success pull-right m15 {{ (Auth::user()->type === 'Admin'?'':'disabled') }}">
		<i class="fa fa-plus"></i>&nbsp;
		New 
	</a>

	<h3>Category</h3>
	
	<p>&nbsp;</p>

	<table class="table table-sm">
		<thead>
			<tr>
				<th>Category</th><th>Parent Category</th><th>Last Updated</th><th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
				<tr>
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
	
@endsection