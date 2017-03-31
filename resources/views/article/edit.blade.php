@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			Home > Admin > Settings
		</div>
		<br>
		
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active">
		    	<a href="#compose" aria-controls="compose" role="tab" data-toggle="tab">Compose</a>
		    </li>

		    <li role="presentation">
		    	<a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">Meta</a>
		    </li>

		    <li role="presentation" class="pull-right">
		    	<button id="btn-submit" class="btn btn-success">Save</button>
		    </li>
		  </ul>

		  <!-- Tab panes -->
		  <form method="post" action="{{route('article-save')}}" id="frm-edit">
		  	{{ csrf_field() }}
		  	{!! method_field('patch') !!}
		  	<input type="hidden" name="id" value="{{$article->id}}">
		  	<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="compose">
			    	<div class="m15">
				    	<div class="form-group">
					    <label for="inputTitle">Article Heading</label>
					    <input 
					    	type="title" 
					    	class="form-control custom-control" 
					    	id="inputTitle" 
					    	placeholder="A great new article..."
					    	name="head" 
					    	data-validation='required'
					    	value="{{$article->title}}"
					    />
					</div>

					<div class="form-group">
					    <label for="inputCat">Select a category</label>
					    <select 
					    	class="form-control custom-control" 
					    	id="inputCat" 
					    	name="cat">
					    </select>
					</div>
				    	
				    	<div class="form-group">
					    <label for="inputIntro">Short Summary</label>
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputIntro" 
					    	placeholder="Let me introduce the story by..."
					    	name="summary"
					    	>{{$article->intro}}</textarea>
					</div>

				    	<div class="form-group">
					    <label for="inputText">Article Body</label>
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputText" 
					    	placeholder="Once up on a time there was a blogger..."
					    	name="body"
					    	style="height: 350px" 
					    	data-validation='required'
					    	>{{$article->fulltext}}</textarea>
					</div>
			    	</div>
			    </div><!-- compose panel -->
			    <div role="tabpanel" class="tab-pane" id="meta">
			    	<div class="m15">
			    		<div class="form-group">
					    <label for="inputMetakey">Meta Keys</label>
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputMetakey" 
					    	placeholder="some, awesome, unique, key, words"
					    	name="keys" 
					    	data-validation='required'
					    	>{{$article->metakey}}</textarea>
					</div>

				    	<div class="form-group">
					    <label for="inputMetaDesc">Meta Description</label>
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputMetaDesc" 
					    	placeholder="Some description about why this article is great!"
					    	name="desc" 
					    	data-validation='required'
					    	>{{$article->metadesc}}</textarea>
					</div>

					<div class="checkbox">
					    <label for="inputPublish">
						    <input
						    	type="checkbox" 
						    	class="cust1om-control" 
						    	id="inputPublish" 
						    	name="publish" 
						    	value="1"
						    	@if($article->publish == "1") checked @endif
						    	> The article is viewable
					    </label>
					</div>
			    	</div>
			    </div><!-- meta panel -->
		  </div><!-- tabcontent -->
		</form>
	</div>
	
@endsection


@section('page.script')
	<script>
		$('#btn-submit').click (function () {
			if (validate('#frm-edit')) 
				$('#frm-edit').submit();
		});

		$(document).ready(function () {
			populateSelect ('#inputCat', 
				'{{route("api-categories")}}',
				{"key": "record", "value":"label"},
				'{{$article->category_id}}');
		});

	</script>
@endsection