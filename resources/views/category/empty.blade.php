@extends('layouts.app')

@section('aside')
	@include('partials.category.menu')
@endsection

@section('main')

	<div class="p30">
		<div class="topline">
			<a href="/">Home</a> &gt; 
		</div>
		<h3>{{$category}}</h3>
		<hr>
		This is an empty category
		<p>&nbsp;</p>
	</div>
	
@endsection