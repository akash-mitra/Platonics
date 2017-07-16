<ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal"> 
                    <i class="fa fa-flash"></i>&nbsp; 
                    Sign In
                </a>
            </li>
            
        @else
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <div style='background-image: url("{{ Auth::user()->avatar }}"); 
                        width: 35px; 
                        height: 35px; 
                        background-size: cover; 
                        background-position: center; 
                        border-radius: 50%;
                        margin:-7px 10px 0 -3px; 
                        float:left'>
                    </div>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('profile')}}">
                            <i class="fa fa-fw fa-user"></i>&nbsp;
                            Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-fw fa-sign-out"></i>&nbsp;
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    @if(Auth::user()->type != 'Registered')
                    <a class="dropdown-item" href="{{ route('admin')}}">
                        <i class="fa fa-fw fa-gear"></i>&nbsp;
                        {{ Auth::user()->type }} Panel
                    </a>
                    @endif
                </div>
            </li>
        @endif
</ul>