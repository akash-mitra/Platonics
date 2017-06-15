@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')
	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt;
			<a href="{{route('admin')}}">Admin</a> &gt;
			<a href="{{route('page-index')}}">Pages</a> &gt;
		</div>
		<br>
		
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">

		    <li role="presentation" class="active">
		    	<a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a>
		    </li>

		    <li role="presentation">
		    	<a href="#compose" aria-controls="compose" role="tab" data-toggle="tab">Compose</a>
		    </li>

		    <li role="presentation">
		    	<a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">Meta</a>
		    </li>

		    <li role="presentation">
		    	<a href="#manage" aria-controls="manage" role="tab" data-toggle="tab">Manage</a>
		    </li>
		    

		    <li role="presentation" class="pull-right">
		    	<button id="btn-submit" class="btn btn-success">Save</button>
		    </li>
		    <li role="presentation" class="pull-right">
		    	&nbsp;
		    </li>
		    <li role="presentation" class="pull-right">
		    	<button id="btn-close" class="btn btn-default">Close</button>
		    </li>
		  </ul>

		  <!-- Tab panes -->
		  <form method="post" action="{{route('page-save')}}" id="frm-edit">
		  	{{ csrf_field() }}
		  	{!! method_field('patch') !!}
		  	<input type="hidden" name="id" value="{{$page->id}}">
		  	<div class="tab-content">
		  	    <div role="tabpanel" class="tab-pane active" id="info">
			    	<div class="m15">
				    	<div class="form-group">
					    <label for="inputTitle">Page Heading</label>
					    <input 
					    	type="title" 
					    	class="form-control custom-control" 
					    	id="inputTitle" 
					    	placeholder="A great new article page..."
					    	name="head" 
					    	data-validation='required'
					    	value="{{$page->title}}"
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
					    	>{{$page->intro}}</textarea>
					</div>
			    	</div>
			    </div><!-- info panel -->
			    <div role="tabpanel" class="tab-pane" id="compose">
			    	<div class="m15">
				    	<div class="form-group">
					    <!-- <label for="inputText">Page Body</label> -->
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputText" 
					    	placeholder="Once up on a time there was a blogger..."
					    	name="body" 
					    	oninput="this.editor.update()" 
					    	style="height: 350px" 
					    	data-validation='required'
					    	>{{$page->markdown}}</textarea>
					</div>

					<label>Preview Pane</label>
					<div id="preview">
						 <!-- place for the preview to appear -->
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
					    	>{{$page->metakey}}</textarea>
					</div>

				    	<div class="form-group">
					    <label for="inputMetaDesc">Meta Description</label>
					    <textarea 
					    	class="form-control custom-control" 
					    	id="inputMetaDesc" 
					    	placeholder="Some description about why this article page is great!"
					    	name="desc" 
					    	data-validation='required'
					    	>{{$page->metadesc}}</textarea>
					</div>

					<div class="checkbox">
					    <label for="inputPublish">
						    <input
						    	type="checkbox" 
						    	class="cust1om-control" 
						    	id="inputPublish" 
						    	name="publish" 
						    	value="1"
						    	@if($page->publish == "1") checked @endif
						    	> This page is viewable (published)
					    </label>
					</div>
			    	</div>
			    </div><!-- meta panel -->
			    <div role="tabpanel" class="tab-pane" id="manage">
			    	<div class="m15">
			    		<h4>Delete Page</h4>
			    		<p>
			    			If you delete a page, there is no way to retrieve it back. Alternatively, you may also unpublish or hide an page by going to "Meta" tab and unticking "This Page is viewable" checkbox.
			    		</p>
				    	<a href="#" id="btnDelPage" class="btn btn-danger">
				    		Delete this page
				    	</a>
				    	<hr>
				    	<p>&nbsp;</p>
			    	</div>
			    </div><!-- manage panel -->
		  	</div><!-- tabcontent -->
		</form>


		<form method="POST" action="{{route('page-delete', $page->id)}}" id="frm-delete">
			{{csrf_field()}}
		</form>
	</div>
	
@endsection


@section('page.script')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.7.1/remarkable.min.js"></script>
	<script>

		var simplemde;

		$('#btn-close').click (function () {
			location.href= "{{route('page-index')}}";
		});
		
		$('#btn-submit').click (function () {
			if (validate('#frm-edit')) 
				$('#frm-edit').submit();
		});

		$('#btnDelPage').click (function () {
			if(confirm('Are you sure to delete this page?')) {
				$('#frm-delete').submit();
			}
		});

		$(document).ready(function () {

			// invoke the markdown editor in the textarea
			new Editor (gebi("inputText"), gebi("preview"));
			// textarea
			// simplemde = new SimpleMDE({ 
			// 	element: $("#inputText")[0],
			// 	autoDownloadFontAwesome: false,
			// 	autofocus: true,
			// 	spellChecker: true,
			// 	toolbar: [
			// 			"heading-3", "bold", "italic", "|", 
			// 			"ordered-list", "unordered-list", "quote", "table", "code", "|",
			// 			"link", "image", "|",
			// 			"side-by-side", "preview", "fullscreen"
			// 		],
			// });

			// //setTimeout(function() { simplemde.codemirror.refresh(); }, 0);
			// setTimeout(function() {
			// 	$( "div.CodeMirror-scroll" )[0].click();
			// 	$( "div.CodeMirror-scroll" ).trigger('click');
			// 	$( "#inputText" ).trigger('click');
			// }, 1000);

			// $( "div.CodeMirror-scroll" )[0].click();
			// $( "div.CodeMirror-scroll" ).trigger('click');
			// $( "#inputText" ).trigger('click');

			populateSelect ('#inputCat', 
				'{{route("api-categories")}}',
				{"key": "record", "value":"label"},
				'{{$page->category_id}}');

			// if the parent category id is blank in the database
			// the same is represented as "--" in front-end	
			let blankChoice = false;
			@if(empty($page->parent_id))	
				blankChoice = true;
			@endif

			// add one aadditional record for blank category "--"
			$('#inputCat').append($('<option>', {
				    value: '',
				    text: 'Uncategorized',
				    selected: blankChoice
			}));
		});

	</script>
@endsection