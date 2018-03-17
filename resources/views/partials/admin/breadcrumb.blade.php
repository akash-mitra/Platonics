<ol class="breadcrumb custom-breadcrumb">
	<li class="breadcrumb-item">
		<a href="/">Home</a>		
	</li>

	<li class="breadcrumb-item">
		<a href="{{route('admin')}}">Admin</a>
	</li>

	@if(isset($leafPage))
		<li class="breadcrumb-item">{{ $leafPage }}</li>
	@endif
</ol>