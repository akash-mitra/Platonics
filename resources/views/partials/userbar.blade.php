<ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li class="nav-item">
                <a class="btn btn-sm btn-outline-primary" href="#" data-toggle="modal" data-target="#loginModal"> 
                    Sign In
                </a>
            </li>
            
        @else
            <li class="nav-item dropdown">

                <a class="text-muted nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    
                    <img id="user-profile-pic" src="{{ Auth::user()->avatar }}" class="pp-r pp-sm" alt="User's Photo">
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a id="user-profile-url" class="dropdown-item" href="{{ route('profile')}}">
                            
                            Profile
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                    @if(Auth::user()->type != 'Registered')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin')}}">
                            
                            {{ Auth::user()->type }} Panel
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        
                        Logout
                    </a>
                </div>
            </li>
        @endif
</ul>