@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["settings" => true])
@endsection


@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Settings'])
@endsection

@section('main')
	
<div class="row mb-5">
	<div class="col-md-12">
		<h3>Settings</h3>
	</div>

	<div class="col-md-12">

		<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="storage-tab" data-toggle="tab" href="#storage" role="tab" aria-controls="storage" aria-selected="true">Media Storage</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="storage" role="tabpanel" aria-labelledby="storage-tab">
	  <div class="card">		  
		  <div class="card-body">
			  @include('partials.admin.storage')
		  </div>
	  </div>
  </div>
  <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
  <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">...</div>
  <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...</div>
</div>
		
	</div>
</div>
	
@endsection

@section('page.script')

	<script>
		

		var saveStorage = function () {
			var btn = $(this);
			var storageSaveParam = {
				"to": "{{route('set-config', 'storage')}}",
				"data": {
					"value": {
						"apiKey": $('#inputKey').val(),
						"apiSecret": $('#inputSecret').val(),
						"region": $('#inputRegion').val(),
						"bucket": $('#inputBucket').val(),
						"type": 's3'
					}
				},
				"before": function () { $(btn).text('Saving') },
				"success": function() { $(btn).text ('Save') },
				"error": function () { $(btn).text ('Error') },
				"method": "post"
			}
			makeAjaxRequest(storageSaveParam);
		}


		$(document).ready (function () {
			$('#btnSaveStorage').click(saveStorage);
		});
	</script>
@endsection