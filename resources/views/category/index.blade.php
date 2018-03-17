@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["categories" => true])
@endsection


@section('header')
	@include('partials.category.breadcrumb')
@endsection


@section('main')
<div class="row mb-5">
	<div class="col-md-12">
		<h2 class="float-left">
			Categories
		</h2>
		@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
		<a href="{{ route('category-create')}}" class="float-right btn btn-primary btn-gradient btn-sm">
			<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;
			New Category
		</a>
		@endif
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-sm" id="b4-dt-list">
					<thead>
						<tr>
							<th>Category</th>
							<th>Parent Category</th>
							<th  class="d-none d-md-block">Last Updated</th>
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
								
								<td class="d-none d-md-block">
									{{ $category->updated_at->diffForHumans()}}
								</td>
								@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
									<td>
										<a class="btn btn-sm btn-secondary btn-gradient waves-effect waves-light" href="{{route('category-edit', $category->id)}}">
											<i class="batch-icon batch-icon-pencil"></i>
										</a>
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>	
			</div>
		</div>
	</div>
</div>
@endsection


@section('page.script')

	@include('vendor.datatables')

@endsection