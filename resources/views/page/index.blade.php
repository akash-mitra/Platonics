@extends('layouts.admin')

@section('page.css')

<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
	#tabList_filter {
		float: left;
		text-align: left;
		width: 100%;
		margin-left: -10px;

	}

	#tabList_filter label {
		width: 100% !important;
	}

	#tabList_filter input {
		width: 100% !important;
		display: block;
		padding: .375rem .75rem;
		font-size: 1rem;
		line-height: 1.5;
		color: #495057;
		background-color: #fff;
		background-image: none;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}


</style>
@endsection

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	@include('partials.admin.breadcrumb')
	
	@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
		<a href="{{route('page-editor')}}" class="btn btn-light pull-right">
			<i class="fa fa-plus"></i>&nbsp;
			Create Page
		</a>
	@endif

	<h3>Pages</h3>
	
	<p></p>
	
	<table class="table table-sm" id="tabList">
		<thead>
			<tr>
				<th>#</th><th>Title</th><th>Category</th><th>Author</th><th>Published</th>
				@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
					<th>Edit</th>
				@endif
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

					@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
						<td>
							<a class="btn btn-sm btn-default {{ (Auth::guest() != true && Auth::user()->type === 'Registered'?'disabled':'') }}" href="{{route('page-editor', $page->id)}}">
								<i class="fa fa-pencil-square-o"></i>&nbsp;
							</a>
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>	
	
	<!-- <nav class="d-flex justify-content-center">
         $pages->links('vendor.pagination.bootstrap-4') 
	</nav> -->
	<p>&nbsp;</p>
	
@endsection

@section('page.script')

<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function() { 
		$('#tabList').DataTable({
			"dom": "ftip",
			"lengthChange": false,
			"language": {
				"search": "_INPUT_",
				"searchPlaceholder": "Type article, category or author names to search..."
			}
		}) 
	})
</script>

@endsection