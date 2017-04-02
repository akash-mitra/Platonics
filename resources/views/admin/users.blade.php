@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; 
			<a href="{{route('admin')}}">Admin</a> &gt; Users
		</div>
		
		
		<!-- <a href="{{route('category-create')}}" class="btn btn-success pull-right m15">
			<i class="fa fa-plus-square-o"></i>&nbsp;
			New Category
		</a> -->

		<h3>User Management</h3>
		<h5>
			List of all users
		</h5>
		<hr>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>ID</th><th>User Name</th><th>Type</th><th>Email</th><th>Created</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($users as $u)
			      <tr>
				<td>{{$u->id}}</td>
				<td>
					<a href="{{route('user', $u->slug)}}">
					<img 
					    src="{{$u->avatar}}" 
					    align="left" 
					    style="width: 30px; margin-right: 10px; border-radius: 15px"
					    />
					</a>
					{{$u->name}}
				</td>
				<td>
				<!-- Split button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-default" id="btn-{{$u->id}}" disabled>
				  	@if($u->type == 'Admin')
						<i class="fa fa-dot-circle-o"></i>&nbsp;
					@elseif($u->type == 'Registered')
						<i class="fa fa-user-o"></i>&nbsp; 
					@elseif($u->type == 'Editor')
						<i class="fa fa-scissors"></i>&nbsp; 
					@elseif($u->type == 'Author')
						<i class="fa fa-pencil"></i>&nbsp; 
					@endif
				  </button>
				  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <span class="caret"></span>
				    <span class="sr-only">Toggle Dropdown</span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a href="#" onclick="ajaxMakeAdmin('{{$u->slug}}', '{{$u->id}}')">
				    <i class="fa fa-fw fa-dot-circle-o"></i>&nbsp;
				    	Make Admin
				    </a></li>
				    <li><a href="#" onclick="ajaxMakeAuthor('{{$u->slug}}', '{{$u->id}}')">
				    <i class="fa fa-fw fa-pencil"></i>&nbsp;
				    	Make Author
				    </a></li>
				    <li><a href="#" onclick="ajaxMakeEditor('{{$u->slug}}', '{{$u->id}}')">
				    <i class="fa fa-fw fa-scissors"></i>&nbsp;
				    	Make Editor
				    </a></li>
				    <li><a href="#" onclick="ajaxMakeGeneral('{{$u->slug}}', '{{$u->id}}')">
				    <i class="fa fa-fw fa-user-o"></i>&nbsp;
				    	Make General Member
				    </a></li>
				    <li><a href="{{route('delete-user', $u->slug)}}">
				    <i class="fa fa-fw fa-remove"></i>&nbsp;
				    	Delete
				    </a></li>
				  </ul>
				</div>
				
				</td>
				<td>{{$u->email}}</td>
				<td>{{$u->created_at->diffForHumans()}}</td>
			      </tr>
			    @endforeach
			</tbody>
		</table>		
	</div>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
@endsection

@section('page.script')
	<script>
	function ajaxMakeAdmin (slug, src) { ajaxChangeType (slug, 'Admin', src);	}
	function ajaxMakeAuthor (slug, src) { ajaxChangeType (slug, 'Author', src);	}
	function ajaxMakeEditor (slug, src) { ajaxChangeType (slug, 'Editor', src);	}
	function ajaxMakeGeneral (slug, src) { ajaxChangeType (slug, 'Registered', src);}

	function ajaxChangeType (slug, type, src)
	{
		makeAjaxRequest ({
			"to": "{{route('user-change-type')}}",
			"method": "post",
			"data": { "slug": slug, "type": type },
			"success": function () {$('#btn-'+src).html(getIconByUserType (type));},
			"before": function () {$('#btn-'+src).html('<i class="fa fa-spinner fa-spin fa-fw"></i>&nbsp;');},
			"error": function (msg) {
				$('#btn-'+src).html('<i class="fa fa-exclamation-triangle"></i>&nbsp;');
				alert ('Error Occurred: ' + msg.responseText);
			}
		});	
	}
	</script>
@endsection