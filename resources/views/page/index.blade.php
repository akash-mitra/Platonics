@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["pages" => true])
@endsection

 
@section('header')
	@include('partials.page.breadcrumb')
@endsection


@section('main')	
<div class="row mb-5">
	<div class="col-md-12">
		<div class="float-left">
			<h3>Pages</h3>
			<p>List of articles published in the Blog</p>
		</div>
		
		<a href="{{ route('page-editor')}}" class="float-right btn btn-primary btn-gradient">
			<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;
			New Page
		</a>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-sm table-hover" id="b4-dt-list">
					<thead>
						<tr>
							<th class="d-none d-lg-block">#</th>
							<th>Title</th>
							<th class="d-none d-lg-block">Author</th>
							<th>Category</th>
							<th class="d-none d-md-block">Published</th>
							@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
								<th>Edit</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach($pages as $page)
							<tr>
								<td class="d-none d-lg-block">{{ $loop->iteration }}</td>	
								<td>
									<a class="" href="{{ '/' . str_slug($page->category) . '/' . str_slug($page->id . ' ' . $page->title, '-')}}">
									{{$page->title}}
									</a>
								</td>
								<td class="d-none d-lg-block">{{$page->author}}</td>
								<td>{{empty($page->category)?'N/A':$page->category}}</td>
								<td class="d-none d-md-block">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $page->created_at)->format('d-M-y')}}</td>

								@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
									<td>
										<a class="{{ (Auth::guest() != true && Auth::user()->type === 'Registered'?'disabled':'') }}" href="{{route('page-editor', $page->id)}}">
											<i class="fa fa-pencil-square-o"></i>&nbsp;
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