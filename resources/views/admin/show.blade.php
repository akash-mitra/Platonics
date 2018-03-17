@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["dashboard" => true])
@endsection


@section('header')
	@include('partials.admin.breadcrumb')
@endsection

@section('main')
	
<div class="row mb-5">
	<div class="col-md-12">
		<h2>Dashboard</h2>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
			</div>
		</div>
	</div>
</div>
	
@endsection