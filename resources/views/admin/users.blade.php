@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["users" => true])
@endsection

 
@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Users'])
@endsection

@section('main')
	<div class="row mb-5">
	<div class="col-md-12">
		<div class="float-left">
			<h3>Users</h3>
			<p>List of users registered to the blog</p>
		</div>
		
		<!-- <a href="{{ route('page-editor')}}" class="float-right btn btn-primary btn-gradient bqtn-sm">
			<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;
			New Page
		</a> -->
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-sm table-hover" id="b4-dt-list">
					<thead>
						<tr>
							<th>User Name</th>
							<th>Type</th>
							<!-- @if(Auth::user()->type != 'Author')
							<th>Email</th>
							@endif -->
							<th>Joined</th> 
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
								class="avatar"
								/>
							</a>
							{{$u->name}}
							
							@if($u->type == 'Author')
								<span class="user-types badge badge-primary">Author</span>
							@elseif($u->type == 'Editor')
								<span class="user-types badge badge-warning">Editor</span>
							@elseif($u->type == 'Admin')
								<span class="user-types badge badge-danger">Admin</span>
							@else 
								<span class="user-types"></span>
							@endif
						</td>
						<td>
						<!-- Split button -->
						<div class="btn-group" role="group">
							<button 
							type="button" 
							class="btn btn-sm btn-outline-secondary dropdown-toggle" 
							id="btn-{{$u->id}}" 
							data-toggle="dropdown" 
							aria-haspopup="true" 
							aria-expanded="false">
								@if($u->type == 'Admin')
									<i class="fas fa-user-secret"></i>
								@elseif($u->type == 'Registered')
									<i class="far fa-user"></i>
								@elseif($u->type == 'Editor')
									<i class="fas fa-pencil-alt"></i>
								@elseif($u->type == 'Author')
									<i class="far fa-edit"></i>
								@endif
							</button>
							@if(Auth::user()->type == 'Admin')
							<div class="dropdown-menu" aria-labelledby="btn-{{$u->id}}">
									<a class="dropdown-item" 
										href="#" 
										onclick="ajaxMakeAdmin('{{$u->slug}}', '{{$u->id}}')">
										<i class="fas fa-user-secret"></i>&nbsp;
										Make Admin
									</a>
									<a class="dropdown-item" 
										href="#" 
										onclick="ajaxMakeAuthor('{{$u->slug}}', '{{$u->id}}')">
										<i class="far fa-edit"></i>&nbsp;
										Make Author
									</a>
									<a class="dropdown-item" 
										href="#" 
										onclick="ajaxMakeEditor('{{$u->slug}}', '{{$u->id}}')">
										<i class="fas fa-pencil-alt"></i>&nbsp;
										Make Editor
									</a>
									<a class="dropdown-item" 
										href="#" 
										onclick="ajaxMakeGeneral('{{$u->slug}}', '{{$u->id}}')">
										<i class="far fa-user"></i>&nbsp;
										Make General Member
									</a>
									<a class="dropdown-item" 
										href="{{route('delete-user', $u->slug)}}">
										<i class="fas fa-user-times"></i>&nbsp;
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
			</div>
		</div>
	</div>
</div>
@endsection

@section('page.script')
	<script>
	function ajaxMakeAdmin (slug, user_id) { ajaxChangeType (slug, 'Admin', user_id);	}
	function ajaxMakeAuthor (slug, user_id) { ajaxChangeType (slug, 'Author', user_id);	}
	function ajaxMakeEditor (slug, user_id) { ajaxChangeType (slug, 'Editor', user_id);	}
	function ajaxMakeGeneral (slug, user_id) { ajaxChangeType (slug, 'Registered', user_id);}

	function ajaxChangeType (slug, type, user_id)
	{
		makeAjaxRequest ({
			"to": "{{route('user-change-type')}}",
			"method": "post",
			"data": { "slug": slug, "type": type },
			"success": function () {
				var btn = $('#btn-'+user_id);
				btn.html(getIconByUserType (type));
				btn.closest('tr').find('.user-types').replaceWith(getBadgeByUserType(type));
			},
			"before": function () {$('#btn-'+user_id).html('<i class="fas fa-spinner fa-spin"></i>&nbsp;');},
			"error": function (msg) {
				$('#btn-'+user_id).html('<i class="fas fa-exclamation-circle"></i>&nbsp;');
				alert ('Error Occurred: ' + msg.responseText);
			}
		});	
	}
	</script>

	@include('vendor.datatables')

@endsection