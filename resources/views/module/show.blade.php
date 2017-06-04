@extends('layouts.app')

@section('aside')
	@include('partials.admin.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="{{route('admin')}}">Admin</a> > 
			<a href="{{route('module-list')}}">Modules</a> >
		</div>
		
		<p></p>
		
		<a href="{{route('module-edit', $module->id)}}" class="btn btn-warning pull-right">Edit</a>

		<h3>{{$module->name}}</h3>		
		<hr>

		<div>
		@php 
			eval(BladeHelper::loadModule("Something"));

		@endphp
		</div>
		<p></p>

		<h4>Code</h4>
		<pre class="solaris">{{ $module->html }}</pre>
	</div>
	
@endsection