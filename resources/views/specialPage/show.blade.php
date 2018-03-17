@extends('layouts.app-simple')

@section('title')
	{{$name}}
	<hr>
@endsection

@section('body')
	{!! $content !!}
@endsection
