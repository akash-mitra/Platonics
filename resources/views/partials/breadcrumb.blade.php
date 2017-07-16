<div class="topline">
	<ol class="breadcrumb custom-breadcrumb">
		<li class="breadcrumb-item">
			<a href="/">Home</a>		
		</li>

		@foreach($content->getContentHierarchies() as $item)
			<li class="breadcrumb-item">
				<a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
			</li>
		@endforeach
	</ol>
</div>