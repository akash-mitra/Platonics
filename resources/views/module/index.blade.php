@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; Modules
		</div>
		
		
		<a href="{{route('module-create')}}" class="btn btn-success pull-right m15">
			<i class="fa fa-plus-square-o"></i>&nbsp;
			New Module
		</a>

		<h3>Module</h3>
		<h5>
			List of all modules
		</h5>
		<hr>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Module</th><th>Last Updated</th><th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($modules as $m)
					<tr>
						<td>
							<a class="" href="{{route('module-show', $m->id)}}">
							{{$m->name}}
							</a>
						</td>
						<td>
							{{ $m->updated_at->diffForHumans()}}
						</td>
						<td>
							<a class="btn btn-sm btn-default" href="{{route('module-edit', $m->id)}}">
								<i class="fa fa-pencil-square-o"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>		
	</div>
	
@endsection