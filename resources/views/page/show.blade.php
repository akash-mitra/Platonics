@extends('layouts.app')


@section('title')
	{{$page->title}}
@endsection

@section('meta')
	<span class="small">
			Written by <a href="{{$page->author->url}}">{{$page->author->name}}</a>.
	</span>
	<span class="small">
			Last updated {{$page->updated_at->diffForHumans()}}.
	</span>
@endsection

@section('lead')
	{!! $page->intro !!}
@endsection

@section('body')
	{!! $page->markup !!}
@endsection

