@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	@include('partials.admin.breadcrumb')
	
	<a href="{{route('page-create')}}" class="btn btn-success pull-right m15 {{ (Auth::user()->type === 'Registered'?'disabled':'') }}">
		<i class="fa fa-plus"></i>&nbsp;
		New
	</a>

	<h3>Pages</h3>
	
	<p>&nbsp;</p>
	
	<table class="table table-sm">
		<thead>
			<tr>
				<th>Title</th><th>Category</th><th>Author</th><th>Published</th><th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($pages as $page)
				<tr>	
					<td>
						<a class="" href="{{ '/' . str_slug($page->category) . '/' . str_slug($page->id . ' ' . $page->title, '-')}}">
						{{$page->title}}
						</a>
					</td>
					<td>{{empty($page->category)?'N/A':$page->category}}</td>
					<td>{{$page->author}}</td>
					<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->created_at)->format('d-M-y')}}</td>
					<!-- <td>
						{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->diffForHumans()}}
					</td> -->
					<td>
						<a class="btn btn-sm btn-default {{ (Auth::user()->type === 'Registered'?'disabled':'') }}" href="{{route('page-edit', $page->id)}}">
							<i class="fa fa-pencil-square-o"></i>&nbsp;
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>		
	
@endsection