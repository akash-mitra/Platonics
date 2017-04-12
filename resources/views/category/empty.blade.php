@extends('layouts.app')

@section('aside')
	@include('partials.category.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; 
		</div>
		<h3>{{$category->name}}</h3>
		<p>
			{{$category->description}}
		</p>
		<hr>
		This is an empty category
		<p>&nbsp;</p>
	</div>
	
@endsection