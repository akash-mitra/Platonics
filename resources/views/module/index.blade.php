@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["modules" => true])
@endsection


@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Module'])
@endsection


@section('main')
<div class="row mb-5">
	<div class="col-md-12">
		<h2 class="float-left">
			Modules
		</h2>
		@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
		<!-- <a href="{{ 1 }}" class="float-right btn btn-primary btn-gradient btn-sm">
			<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;
			New Category
		</a> -->
		@endif
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-sm" id="b4-dt-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody>
						@foreach($modules as $module)
							<tr>
								<td>
									{{ $module->id }}
								</td>
								<td>
									{{ $module->name }}
								</td>
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

	@include('vendor.datatables')

@endsection