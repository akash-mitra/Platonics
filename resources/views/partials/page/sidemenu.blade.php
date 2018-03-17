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
			<h6 class="nav-header">Tools</h6>
		</li>

        <li class="nav-item">
            <a id="btn-add-image" class="nav-link unselectable disabled">
                <i class="batch-icon  batch-icon-image"></i>&nbsp;
                Add Media
            </a>
        </li>

        <li class="nav-item">
            <a id="btn-add-image" class="nav-link" data-toggle="modal" data-target="#mediaModalUpload">
                <i class="batch-icon  batch-icon-tag-alt-2"></i>&nbsp;
                Add Meta
            </a>
        </li>

	</ul>
	
</nav>