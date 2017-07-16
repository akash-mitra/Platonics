<div class="p30">

	<div class="topline">
		<h5>Setup</h5>
	</div>

	<ul class="submenu" role="navigation">
		<li class="menu-item">
			<a class="menu-entry" href="{{ route('storage') }}">
				<i class="fa fa-hdd-o fa-fw"></i>&nbsp;Storage 
			</a>
		</li>

		<li class="menu-item">
			<a class="menu-entry" href="{{ route('image') }}">
				<i class="fa fa-file-image-o fa-fw"></i>&nbsp;Image 
			</a>
		</li>
	</ul>


	<div class="topline">
		<h5>Contents</h5>
	</div>

	
	<ul class="submenu" role="navigation">
		<li class="menu-item">
			<a href="{{route('page-index')}}">
				<i class="fa fa-file-text-o fa-fw"></i>&nbsp;Pages
			</a>	
		</li>	

		<li class="menu-item">
			<a href="{{route('category-index')}}">
				<i class="fa fa-paperclip fa-fw"></i>&nbsp;Categories
			</a>
		</li>

		<li class="menu-item">
			<a href="{{route('module-list')}}">
				<i class="fa fa-bars fa-fw"></i>&nbsp;Modules
			</a>
		</li>

		<li class="menu-item">
			<a href="#">
				<i class="fa fa-file-text-o fa-fw"></i>&nbsp;Tags
			</a>
		</li>
	</ul>

	<div class="topline">
		<h5>Manage Users</h5>
	</div>
	
	<ul class="submenu" role="navigation">
		<li class="menu-item">
			<a class="menu-entry" href="{{route('admin-users')}}">
				<i class="fa fa-file-text-o fa-fw"></i>&nbsp;User List
			</a>
		</li>
	</ul>

	<!-- <div class="topline">
		<h3>Manage Layouts</h3>
	</div>
	<p></p>
	<ul class="menu-collapsible">
		<li>
			<a href="{{route('admin-designer')}}">Homepage Designer</a>
		</li>
		
	</ul> -->
</div>