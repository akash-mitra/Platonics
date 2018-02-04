<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<h5 class="editor-header">Category</h5>
		    <select 
				class="custom-select" 
				style="border: none; padding-left: 0px" 
		    	id="inputCat" 
		    	name="cat">
		    </select>
		</div>
	</div>
	<div class="col-md-4">
		
		<a href="#" class="btn btn-success pull-right" id="btnSave">Save</a>
		<a href="#" class="btn btn-link pull-right" id="btnClose">Close</a>
	</div>
</div>
<h2 id="pageTitle" class="editable">{!! $page->title !!}</h2>

<h5 class="editor-header" style="margin-top:25px">Summary</h5>
<div id="pageSummary" class="lead editable">{!! $page->intro !!}</div>

<h5 class="editor-header" class="editable" style="margin-top:25px">Full Text</h5>
<div id="pageBody">
	{!! $page->markup !!}
</div>

<p>&nbsp;</p>
