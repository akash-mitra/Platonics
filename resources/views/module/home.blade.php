@extends('layouts.admin')

@section('page.css')
	<style>
		#categoryHierarchy {
			max-height: 200px;
			overflow: scroll;
		}
	</style>
@endsection


@section('aside')
	@include('partials.admin.menu', ["modules" => true])
@endsection


@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Module'])
@endsection


@section('main')
<div class="row mb-5">
	<div class="col-md-12 d-flex justify-content-between">
		<h2 class="mt-3">
			Modules
		</h2>
		<div class="dropdown">
			<a href="#" class="mb-3 btn btn-default dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				New
			</a>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="{{ route('module-show', ['module' => 'comments']) }}">Comments</a>
				<a class="dropdown-item" href="{{ route('module-show', ['module' => 'custom']) }}">Custom HTML</a>
				<a class="dropdown-item" href="#">Adsense</a>
				
			</div>
		</div>
		
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div id="index" class="table-responsive">
				</div>
			</div>
		</div>
				
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="PositionModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="PositionModal">Module Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-content">
		
		<input type="hidden" value="" name="moduleId" id="moduleId">

        <div class="form-group">
			<label for="inputPosition">Position</label>
			<select class="custom-select" name="position" id="inputPosition">
				<option value="hidden">Hide - Do not Show</option>
				<option value="banner">Banner - Show beneath menu</option>
				<option value="left">Left - Show on the Left column</option>
				<option value="right">Right - Show on the Right column</option>
				<option value="top">Top - Before the article</option>
				<option value="bottom">Bottom - At the end of the article</option>
			</select>
		</div>

		<div class="form-group">
			<label for="categoryHierarchy">Show in Category</label>
			<div id="categoryHierarchy" class="border"></div>
		</div>
		
		<div class="form-group">
			<label for="inputExcept">Except Article(s)</label>
			<input type="text" class="form-control" id="inputExcept">
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSaveVisibility">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('page.script')

	<script>

		var meta = {!! json_encode($meta) !!};
		var html = '';

		var createPositionColumn = function (data, row) {
			return '<button type="button" data-row-id="' 
				+ row["id"] 
				+ '" data-toggle="modal" data-target="#positionModal"'
				+ ' class="btn btn-sm btn-info">Set Positions</button>'
		}



		var saveModuleVisibility = function ()
		{
			
			 var btn = $(this),
			 	param = {
				"method": "post",
				"to": "{{ route('module-visibility') }}",
				"data": { 
					"moduleId": $('#moduleId').val(),
					"position": $('#inputPosition').val(),
					"categories": $('[id^="cat-"]:checked').map(function () { 
						return this.getAttribute("name") 
					}).get(),
					"exceptions": $('#inputExcept').val()
				 },
				"before": function () {
					btn.addClass('disabled').attr('disabled', true).text ('Wait...');
				},
				"success": function (data) {
					meta = data.meta; 
					btn.text('Done');
					setTimeout(() => {btn.removeClass('disabled').attr('disabled', false).text ('Save')}, 500);
				 },
				"error": function (data) {
					btn.removeClass('disabled').attr('disabled', false).text ('Save');
					showError (data);
				}
			}
			
			makeAjaxRequest(param);
			
			//console.log( param.data );
		}


		function flat_hierarchy_tree (node, level) {
			
			html += '<li class="py-1">' 
					+ '<div class="custom-control custom-checkbox">'
					+ '<input type="checkbox" name="'+ node.id +'" class="custom-control-input" id="cat-'+ node.id +'">'
					+ '<label class="custom-control-label" for="cat-'+ node.id +'">'
					+ node.name
					+ '</label></div>';

			if (node.children.length > 0) {
				html += '<ul style="list-style: none">';
				for (var k in node.children) {
					flat_hierarchy_tree (node.children[k], level + 1);
				}
				html += '</ul>';
			}
			html += '</li>';
		}


		function searchNodeRecursively (forest, id)
		{
			var nodeFound = null;

			for(var k in forest) {
				var tree = forest[k];
				if (tree.id === id) nodeFound = tree;
				else nodeFound = searchNodeRecursively (tree.children, id);

				if(nodeFound != null) break;
			}

			return nodeFound;
		}

		
		function populateCategoryHierarchy ()
		{
			var param = {
				"to": "{{ route('api-categories') }}",
				"before": function () {},
				"error": function () { showError ('Failed to load Category Information. Reload the page.') },
				"success": function (data) {
					
					// Test data with 3 levels of hierarchy
					// data = [
					// 	{"record": 1, "name": "n1", "parent_record": null},
					// 	{"record": 2, "name": "n2", "parent_record": null},
					// 	{"record": 3, "name": "n3", "parent_record": 2},
					// 	{"record": 4, "name": "n4", "parent_record": 2},
					// 	{"record": 5, "name": "n5", "parent_record": null},
					// 	{"record": 6, "name": "n6", "parent_record": null},
					// 	{"record": 7, "name": "n7", "parent_record": 6},
					// 	{"record": 8, "name": "n8", "parent_record": 7},
					// 	{"record": 9, "name": "n9", "parent_record": 3},
					// 	{"record": 10, "name": "n10", "parent_record": 3},
					// ];
					// sort the array to make sure parent elements are before child elements
					data.sort(function (a, b) { return a.record >= b.record });

					// create node objects and build tree structure with them
					var forest = [];
					for (var i=0; i<data.length; i++) {
						var node = { "id": data[i].record, "name": data[i].name, "children": [] }
						if (data[i].parent_record === null) 
							forest.push (node);
						else {
							// serach that parent record in the 'nodes'
							var parent = searchNodeRecursively(forest, data[i].parent_record);
							parent.children.push(node);
						}
					}
					
					html += '<ul style="list-style: none">';
					for (var k in forest) {
						flat_hierarchy_tree (forest[k], 1);	
					}
					html += '</ul>';
					
					$('#categoryHierarchy').html (html);
					
				}
			};
			makeAjaxRequest (param);
		}

		var findModuleInMeta = function (moduleId)
		{
			// loop over all the positions in meta and search for the module
			var len = meta.positions.length;
			for (var i=0; i<len; i++)
			{	
				var position = meta.positions[i];
				var modules = meta[position];
				
				if (typeof modules != 'undefined') {
					if (moduleId in modules) return modules[moduleId];
				}
			}

			return null;
		}


		$(document).ready(function () {

			//console.log(meta);
			
			populateTableWithJSONData ("post:{{route('module-index')}}", "#index", {
					"name": function (e, row) { return '<a href="/admin/module/' + row["type"] + '/' + row["id"] + '">' + ucfirst(row['name']) + '</a>' },
					"type": ucfirst,
					"Last Updated": function (e, row) { return row['updated_at'].substring(0, 10) },
					"Position": createPositionColumn,
				}, 
				{
					"dataAttribute": "data",
					"class": "table table-sm table-hover border align-middle"
				}
			);


			populateCategoryHierarchy();

			$('#positionModal').on('show.bs.modal', function (event) {
				
				var button = $(event.relatedTarget) 
				var moduleId = button.data('row-id') 
				$('#moduleId').val(moduleId)
				$('[id^="cat-"]').prop('checked', false); // reset the checkboxes
				
				var module = findModuleInMeta (moduleId);
				if (module != null) { 
					// populate the relevant values in form 
					$('#inputPosition').val(module.position);
					var len = module.visible.length;
					for (var i=0; i<len; i++) {
						$('#cat-' + module.visible[i]).prop('checked', true);
					}
					$('#inputExcept').val(module.exceptions);
				}

			})

			$('#btnSaveVisibility').click (saveModuleVisibility);
		});
	</script>

	

@endsection