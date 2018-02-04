@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	@include('partials.admin.breadcrumb')

	@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
		<a href="{{route('category-create')}}" class="btn btn-success pull-right">
			<i class="fa fa-plus"></i>&nbsp;
			New 
		</a>
	@endif

	<h3>Category</h3>
	
	<p>&nbsp;</p>

	<table class="table table-sm">
		<thead>
			<tr>
				<th>Category</th><th>Parent Category</th><th>Last Updated</th>
				@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
					<th>Edit</th>
				@endif
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
					@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
						<td>
							<a class="btn btn-sm btn-default" href="{{route('category-edit', $category->id)}}">
								<i class="fa fa-pencil-square-o"></i>
							</a>
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>		
	
@endsection