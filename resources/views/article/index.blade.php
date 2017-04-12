@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> > <a href="/admin">Admin</a>
		</div>
		
		
		<a href="{{route('article-create')}}" class="btn btn-success pull-right m15">
			<i class="fa fa-plus-square-o"></i>&nbsp;
			New Article
		</a>

		<h3>Article</h3>
		<h5>
			List of all articles
		</h5>
		<hr>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>#</th><th>Title</th><th>Category</th><th>Author</th><th>Published</th><th>Last Updated</th><th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($articles as $article)
					<tr>
						<td>{{$article->id}}</td>
						
						<td>
							<a class="" href="{{route('article-view', str_slug($article->id . ' ' . $article->title))}}">
							{{$article->title}}
							</a>
						</td>
						<td>{{empty($article->category)?'N/A':$article->category}}</td>
						<td>{{$article->author}}</td>
						<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $article->created_at)->toFormattedDateString()}}</td>
						<td>
							{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $article->updated_at)->diffForHumans()}}
						</td>
						<td>
							<a class="btn btn-sm btn-default" href="{{route('article-edit', $article->id)}}">
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