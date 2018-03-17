<div class="row mb-5">
	<div class="col-md-12">

		<div class="card">
			<div class="card-header">
				<select 
					class="form-control" 
					style="border: none; padding-left: 0px" 
					id="inputCat" 
					name="cat">
				</select>
				<h2 id="pageTitle" class="editable">
					{!! $page->title !!} &nbsp;
				</h2>
			</div>
			
			<div class="card-body">
				<h5 class="editor-header" style="margin-top:25px">Summary</h5>
				<div id="pageSummary" class="lead editable">{!! $page->intro !!}</div>

				<h5 class="editor-header" class="editable" style="margin-top:25px">Full Text</h5>
				<div id="pageBody">
					{!! $page->markup !!}
				</div>
			</div>

			<div class="card-footer">
				<button id="btnSave" class="btn btn-primary float-right">
					<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;
					Save
				</button>
			</div>

		</div>

	</div>
</div>