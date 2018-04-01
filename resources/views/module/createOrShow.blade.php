@extends('layouts.admin')

@section('page.css')
	
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
        <h3 class="text-secondary">{{ $type }}</h3>
        @if(! empty($id))
        <button class="btn btn-sm btn-outline-danger" id="btnDelete">Delete</button>
        @endif
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">

                <div class="form-group">
                    <label for="inputName">Module Name</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $name }}" placeholder="Give a name to describe your module">
                </div>
                
                @if ($type === 'custom')
                <!-- Custom HTML related parameters will be added here -->
                <div class="form-group">
                    <label for="inputContent">Custom HTML</label>
                    <textarea name="content" id="inputContent" class="form-control" placeholder="Put your HTML contents here" rows="10">{{ $config['content'] }}</textarea>
                </div>
                <input type="hidden" name="script" value="" id="hInputScript">

                @elseif ($type === 'comments')
                <!-- comments related parameters will be added here -->
                <input type="hidden" name="script" value="comments.js" id="hInputScript">

                @else 
                    <pre>Type parameter undefined</pre>

                @endif

                <input type="hidden" name="id" value="{{ $id }}" id="hInputId">
                
            </div>
            <div class="card-footer">
            
            <button type="button" class="btn btn-primary float-right" id="btnSave">Save Module</button>
            <a class="btn btn-outline-secondary float-right" href="{{route('module-home')}}">Close</a>        
            </div>
		</div>
				
	</div>
</div>

@endsection


@section('page.script')

	<script>
        var saveModuleContents = function () {
            
            var btn = $(this), param = {
                "method": "patch",
                "to": "{{ route('module-update') }}",
                "data": {
                    "id": $('#hInputId').val(),
                    "name": $('#inputName').val(),
                    "type": "{{ $type }}",
                    "config": { 
                        "content": $('#inputContent').val(),
                        "script": $('#hInputScript').val() 
                    }
                },
                "before": function () { btn.text('Saving...').addClass('disabled') },
                "success": function (data) {
                    btn.text('Save').removeClass('disabled')
                    $('#hInputId').val(data.module.id);
                    if (window.history.pushState) {
                        window.history.pushState({}, null, data.url);
                    }
                },
                "error": function () { 
                    btn.text('Save').removeClass('disabled')
                    showError ("Could not save data to server. Try again.")
                }
            };
            makeAjaxRequest (param)
        }

        var deleteModule = function () 
        {
            var btn = $(this), param = {
                "method": "post",
                "to": "{{ route('module-delete') }}",
                "data": {
                    "id": $('#hInputId').val()
                },
                "before": function () { btn.text('Deleting...').addClass('disabled') },
                "success": function () {
                    alert('Module deleted successfully');
                    location.href="{{ route('module-index') }}";
                },
                "error": function () { 
                    btn.text('Delete').removeClass('disabled')
                    showError ("Could not delete module. Try again.")
                }
            };
            makeAjaxRequest (param)
        }
        $(document).ready(function () {
            $('#btnSave').click(saveModuleContents);
            $('#btnDelete').click (deleteModule);
        });
	</script>

@endsection