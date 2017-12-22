@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	@include('partials.admin.breadcrumb')
	
	<a href="{{route('page-editor')}}" class="btn btn-success pull-right m15 {{ (Auth::user()->type === 'Registered'?'disabled':'') }}">
		<i class="fa fa-plus"></i>&nbsp;
		New
	</a>

	<h3>Pages</h3>
	
	<p>Total {{ $pages->total() }} Pages available (Showing {{ $pages->perPage() }} per page). </p>
	
	<table class="table table-sm">
		<thead>
			<tr>
				<th>#</th><th>Title</th><th>Category</th><th>Author</th><th>Published</th><th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($pages as $page)
				<tr>
					<td>{{ $loop->iteration }}</td>	
					<td>
						<a class="" href="{{ '/' . str_slug($page->category) . '/' . str_slug($page->id . ' ' . $page->title, '-')}}">
						{{$page->title}}
						</a>
					</td>
					<td>{{empty($page->category)?'N/A':$page->category}}</td>
					<td>{{$page->author}}</td>
					<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->created_at)->format('d-M-y')}}</td>
					<td>
						<a class="btn btn-sm btn-default {{ (Auth::user()->type === 'Registered'?'disabled':'') }}" href="{{route('page-editor', $page->id)}}">
							<i class="fa fa-pencil-square-o"></i>&nbsp;
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>	
	
	<nav class="d-flex justify-content-center">
        {{ $pages->links('vendor.pagination.bootstrap-4') }}
    </nav>
	
@endsection