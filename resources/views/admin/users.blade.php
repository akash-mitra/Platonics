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
					<th>ID</th><th>User Name</th><th>Email</th><th>Created</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $u)
					<tr>
						<td>{{$u->id}}</td>
						<td>
							<img src="{{$u->avatar}}" align="left" style="width: 30px; margin-right: 10px; border-radius: 15px">
							{{$u->name}}
						</td>
						<td>{{$u->email}}</td>
						<td>{{$u->created_at->diffForHumans()}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>		
	</div>
	
@endsection