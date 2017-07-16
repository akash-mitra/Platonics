@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	@include('partials.admin.breadcrumb')

	<!-- <a href="#" class="btn btn-default disabled pull-right">
		<i class="fa fa-plus"></i>&nbsp;
		New
	</a> -->

	<h3>User Management</h3>
	
	<p>&nbsp;</p>

	<table class="table table-sm">
		<thead>
			<tr>
				<th>User Name</th>
				<th>Type</th>
				<!-- @if(Auth::user()->type != 'Author')
				<th>Email</th>
				@endif -->
				<th>Created</th> 
			</tr>
		</thead>
		<tbody>
		    @foreach($users as $u)
		      <tr>
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
			<div class="btn-group" role="group">
			    <button 
			  	type="button" 
			  	class="btn btn-sm btn-secondary dropdown-toggle" 
			  	id="btn-{{$u->id}}" 
			  	data-toggle="dropdown" 
			  	aria-haspopup="true" 
			  	aria-expanded="false">
				  	@if($u->type == 'Admin')
						<i class="fa fa-fw fa-dot-circle-o"></i>
					@elseif($u->type == 'Registered')
						<i class="fa fa-fw fa-user-o"></i>
					@elseif($u->type == 'Editor')
						<i class="fa fa-fw fa-scissors"></i>
					@elseif($u->type == 'Author')
						<i class="fa fa-fw fa-pencil"></i>
					@endif
			    </button>
			    @if(Auth::user()->type == 'Admin')
				<div class="dropdown-menu" aria-labelledby="btn-{{$u->id}}">
				      	<a class="dropdown-item" 
				      		href="#" 
				      		onclick="ajaxMakeAdmin('{{$u->slug}}', '{{$u->id}}')">
			    			<i class="fa fa-fw fa-dot-circle-o"></i>&nbsp;
			    			Make Admin
			    		</a>
			    		<a class="dropdown-item" 
			    			href="#" 
			    			onclick="ajaxMakeAuthor('{{$u->slug}}', '{{$u->id}}')">
			    			<i class="fa fa-fw fa-pencil"></i>&nbsp;
			    			Make Author
			    		</a>
			    		<a class="dropdown-item" 
			    			href="#" 
			    			onclick="ajaxMakeEditor('{{$u->slug}}', '{{$u->id}}')">
			    			<i class="fa fa-fw fa-scissors"></i>&nbsp;
			    			Make Editor
			    		</a>
			    		<a class="dropdown-item" 
			    			href="#" 
			    			onclick="ajaxMakeGeneral('{{$u->slug}}', '{{$u->id}}')">
			    			<i class="fa fa-fw fa-user-o"></i>&nbsp;
			    			Make General Member
			    		</a>
			    		<a class="dropdown-item" 
			    			href="{{route('delete-user', $u->slug)}}">
			    			<i class="fa fa-fw fa-remove"></i>&nbsp;
			    			Delete
			    		</a>
			  	</div>
			    @endif
			</div>
			<!-- end of split button -->
			</td>

			<!-- @if(Auth::user()->type != 'Author')
			<td>email</td>
			@endif  -->

			<td>{{$u->created_at->format('d-M-y')}}</td>
		      </tr>
		    @endforeach
		</tbody>
	</table>		

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