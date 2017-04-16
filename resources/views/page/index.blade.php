@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> > <a href="/admin">Admin</a>
		</div>
		
		
		<a href="{{route('page-create')}}" class="btn btn-success pull-right m15">
			<i class="fa fa-plus-square-o"></i>&nbsp;
			New Page
		</a>

		<h3>Page</h3>
		<h5>
			List of all pages
		</h5>
		<hr>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>#</th><th>Title</th><th>Category</th><th>Author</th><th>Published</th><th>Last Updated</th><th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pages as $page)
					<tr>
						<td>{{$page->id}}</td>
						
						<td>
							<a class="" href="{{ '/' . str_slug($page->category) . '/' . str_slug($page->id . ' ' . $page->title, '-')}}">
							{{$page->title}}
							</a>
						</td>
						<td>{{empty($page->category)?'N/A':$page->category}}</td>
						<td>{{$page->author}}</td>
						<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->created_at)->toFormattedDateString()}}</td>
						<td>
							{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->diffForHumans()}}
						</td>
						<td>
							<a class="btn btn-sm btn-default" href="{{route('page-edit', $page->id)}}">
								<i class="fa fa-pencil-square-o"></i>&nbsp;
								Edit
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>		
	</div>
	
@endsection