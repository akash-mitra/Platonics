<nav id="sidebar" class="px-0 bg-dark bg-gradient sidebar">
	<ul class="nav nav-pills flex-column">
		<li class="logo-nav-item">
			<a class="navbar-brand" href="#">
				<!-- <img src="assets/img/logo-white.png" width="145" height="32.3" alt="QuillPro"> -->
				BlogVel Admin
			</a>

		</li>
		
		<li class="nav-item">
			<a class="nav-link {{ isset($dashboard) ? 'active' : '' }}" href="/admin">
				<i class="batch-icon batch-icon-browser-alt"></i>
				Dashboard <span class="sr-only">(current)</span>
			</a>
		</li>
		
		<li>
			<h6 class="nav-header">Content</h6>
		</li>
		
		<li class="nav-item">
			<a class="nav-link {{ isset($pages)? 'active' : '' }}" href="{{route('page-index')}}">
				<i class="batch-icon batch-icon-paragraph-alt-justify"></i>&nbsp;Pages
			</a>	
		</li>	

		<li class="nav-item">
			<a class="nav-link {{ isset($categories) ? 'active' : '' }}" href="{{route('category-index')}}">
				<i class="batch-icon  batch-icon-folder"></i>&nbsp;Categories
			</a>
		</li>
		
		@if(Auth::guest() != true && in_array(Auth::user()->type, ['Admin', 'Editor', 'Author']))
		<li class="nav-item">
			<a class="nav-link {{ isset($media) ? 'active' : '' }}" href="{{route('media-index')}}">
				<i class="batch-icon  batch-icon-image"></i>Media
			</a>
		</li>
	
		<li class="nav-item">
			<a class="nav-link {{ isset($module) ? 'active' : '' }}" href="{{route('module-index')}}">
				<i class="batch-icon  batch-icon-image"></i>Modules
			</a>
		</li>
		@endif

	</ul>

	<ul class="nav nav-pills flex-column">
		<li>
			<h6 class="nav-header">Manage</h6>
		</li>
		@if(Auth::guest() != true && Auth::user()->type === 'Admin')
		<li class="nav-item">
			<a class="nav-link {{ isset($users) ? 'active' : '' }}" href="{{route('admin-users')}}">
				<i class="batch-icon batch-icon-users"></i>&nbsp;Users
			</a>
		</li>
		@endif
		<li class="nav-item">
			<a class="nav-link {{ isset($comments) ? 'active' : '' }}" href="{{route('admin-comments')}}">
				<i class="batch-icon batch-icon-speech-bubble-left-tip-chat"></i>&nbsp;Comments
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ isset($posts) ? 'active' : '' }}" href="{{route('admin')}}">
				<i class="batch-icon batch-icon-inbox"></i>&nbsp;Posts
			</a>
		</li>
		
	</ul>

	@if(Auth::guest() != true && Auth::user()->type === 'Admin')
	<ul class="nav nav-pills flex-column">
		<li>
			<h6 class="nav-header">Setting</h6>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ isset($design) ? 'active' : '' }}" href="{{route('admin-design')}}">
				<i class="batch-icon batch-icon-nib"></i>&nbsp;Design
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ isset($revenue) ? 'active' : '' }}" href="{{route('category-index')}}">
				<i class="batch-icon batch-icon-credit-card-alt-3"></i>&nbsp;Revenue
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ isset($advance) ? 'active' : '' }}" href="{{route('category-index')}}">
				<i class="batch-icon batch-icon-flask-full"></i>&nbsp;Advance
			</a>
		</li>

		@if(Auth::guest() != true && Auth::user()->type === 'Admin')
		<li class="nav-item">
			<a class="nav-link {{ isset($special) ? 'active' : '' }}" href="{{route('special-page-index')}}">
				<i class="batch-icon  batch-icon-image"></i>Special Pages
			</a>
		</li>
		@endif
	</ul>
	@endif
	
</nav>