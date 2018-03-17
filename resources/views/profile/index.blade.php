@extends('layouts.app')

@section('head')
	<div class="border">

		<div style="height: 5em; background-color:#222f40">

		</div>

		<div style="background-color:#e7edf3" class="p-4">
			<div class="border d-flex w-100 bg-white">
				<div class="bg-white w-100 p-4" style="margin-top: -50px">
					<img src="{{ $user->avatar }}" alt="Profile Pic" align="left" class="border mr-3">
						<strong>{{ $user->name }}</strong>
					<br>
					<span class="badge badge-info">{{ $user->type }}</span>
					<div class="float-right small text-muted">
						
					</div>
				</div>
			</div>

			<div style="background-color: #f4f5f6; color: #3b4b5b" class="col-12">
				<div class="row">
					<div class="col-6 border-right p-3">
						<strong>ARTICLES</strong>
						<p class="text-muted small">
							<b>{{ count($pages) }}</b> articles written
						</p>
					</div>
					<div class="col-6 borqder p-3">
						<strong>COMMENTS</strong>
						<p class="text-muted small">
							<b>{{ count($user->comments) }}</b> comments
						</p>
					</div>
				</div>	
			</div>

			<div style="background-color: #fefefe" class="col-12 text-muted p-3 clearfix border-top border-bottom small box-shadow">
				<span class="float-left">
					Joined {{ $user->created_at->diffForHumans() }}
				</span>
				<span class="float-right">
					{{ $user->email }}
				</span>
			</div>

			<div class="col-12 py-3 boqrder-bottom">
				<strong>Articles by {{ $user->name }}</strong>
			</div>

			<div class="bg-white border">
				<ul class="list-group list-group-flush">
				@foreach($pages as $page)
					<li class="list-group-item">
						<div class="d-flex w-100 justify-content-between small text-muted">
							<span>{{ $page->name }} &gt;</span>
							<span> {{ \Carbon\Carbon::parse($page->created_at)->diffForHumans() }}</span>
						</div>
						<h5>{{ $page->title }}</h5>
						<p>
							{{ $page->intro }}
						</p>
						
					</li>
				@endforeach
				</ul>
			</div>


			<div class="col-12 py-3 boqrder-bottom">
				<strong>Comments made by {{ $user->name }}</strong>
			</div>

			<div class="bg-white border">
				<ul class="list-group list-group-flush">
				@foreach($user->comments as $comment)
					<li class="list-group-item">
						<div class="d-flex w-100 justify-content-between small text-muted">
							
							<span> {{ $comment->created_at->diffForHumans() }}</span>
						</div>
						<h5>{{ $comment->page->title }}</h5>
						<p>
							{{ $comment->body }}
						</p>
						
					</li>
					
				@endforeach
				</ul>
			</div>


		</div>
	</div>
	
@endsection


@section('page.script')
	<script>
		let commentsRetrieved = false;
		let retrieveParams = {
			method: 'get',
			to: "{{route('comments-by-user', $user->slug)}}",
			before: function () {
				$('#comments').html('<p>&nbsp;</p><div class="text-center"><i class="fa fa-refresh fa-spin"></i> Getting user comments from server...</div>');	
			},
			success: function (r) {displayComments (r, '#comments');},
			error: function () {
				alert('error');
			},
		};

		function getComments() 
		{
			if (commentsRetrieved) return;
			makeAjaxRequest(retrieveParams);
			commentsRetrieved = true;
		}

		function displayComments (comments, e)
		{
			if (typeof comments === 'undefined' || comments.length < 1) {
				$(e).html('<p>No comment retrieved</p>');
				return;
			}
			var strips = '';
			for (let i = 0, l = comments.length; i < l; i++) {
				var c = comments[i];
				strips += '<div class="card"><div class="card-block">'
				  + '<h4 class="card-title">' 
				  + c.page.title 
				  + '</h4>'
    				  + '<p class="card-subtitle small mb-2 text-muted">' 
    				  + c.page.intro 
    				  + '</p>'
    				  + generateCommentStrip(c.user.name, c.user.profile, c.user.avatar, c.text, c.when)
    				  + '<p></p>'
    				  + '<a href="'+c.page.url+'" class="card-link pull-right">'
    				  + "Read Now" + '</a>'
				  + '</div></div><br>' 
				  + '';
			}
			
			$(e).html(strips);
		}
	
	</script>
@endsection