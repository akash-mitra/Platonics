{{ csrf_field() }}
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="info">
		<br>
	    	<div class="form-group">
		    <label for="inputTitle">Page Heading</label>
		    <input 
		    	type="text" 
		    	class="form-control custom-control" 
		    	id="inputTitle" 
		    	placeholder="A great new article page..."
		    	name="head" 
		    	data-validation='required' 
		    	value="{{ old('head') ?? $page->title }}"
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
		    	name="summary">{{ old('summary') ?? $page->intro }}</textarea>
		</div>
	</div><!-- info panel -->


	<div role="tabpanel" class="tab-pane" id="compose">
		<br>
		<label>Preview Pane</label>
		<div id="preview">
		</div>
		<br>
		<div class="form-group">
		    <label for="inputText">Page Body</label>
		    <textarea 
		    	class="form-control no-hor-resize" 
		    	id="inputText" 
		    	oninput="this.editor.update()" 
		    	placeholder="Once up on a time there was a blogger..."
		    	name="body"
		    	style="height: 250px" 
		    	data-validation='required'>{{ old('body') ?? $page->markdown }}</textarea>
		</div>
		
	</div><!-- compose panel -->


	<div role="tabpanel" class="tab-pane" id="meta">
		<br>
		<div class="form-group">
		    <label for="inputMetakey">Meta Keys</label>
		    <textarea 
		    	class="form-control custom-control" 
		    	id="inputMetakey" 
		    	placeholder="some, awesome, unique, key, words"
		    	name="keys" 
		    	data-validation='required'>{{ old('keys') ?? $page->metakey }}</textarea>
		</div>

	    	<div class="form-group">
		    <label for="inputMetaDesc">Meta Description</label>
		    <textarea 
		    	class="form-control custom-control" 
		    	id="inputMetaDesc" 
		    	placeholder="Some description about why this article page is great!"
		    	name="desc" 
		    	data-validation='required'>{{ old('desc') ?? $page->metadesc }}</textarea>
		</div>

		<div class="checkbox">
		    <label for="inputPublish">
			    <input
			    	type="checkbox" 
			    	class="cust1om-control" 
			    	id="inputPublish" 
			    	name="publish" 
			    	value="1"
			    	value="1" 
				@if($page->publish == "1") checked @endif> This page is viewable (published)
		    </label>
		</div>
	</div><!-- meta panel -->
	<div role="tabpanel" class="tab-pane" id="manage">
	  	<br>
    		<h4>Delete Page</h4>
    		<p>
    			If you delete a page, there is no way to retrieve it back. Alternatively, you may also unpublish or hide an page by going to "Meta" tab and unticking "This Page is viewable" checkbox.
    		</p>
	    	<a href="#" id="btnDelPage" class="btn btn-danger">
	    		Delete this page
	    	</a>
	    	
	    	<p>&nbsp;</p>
	    
	</div><!-- manage panel -->
</div><!-- tabcontent -->
