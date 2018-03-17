<ul class="navbar-nav ml-5 navbar-profile">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbar-dropdown-navbar-profile" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
            <div class="profile-name">
                {{ Auth::user()->name }}
            </div>
            <div class="profile-picture bg-gradient-0 bg-primary has-message-0 float-right">
                <img src="{{ Auth::user()->avatar }}" width="44" height="44">
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-navbar-profile">
            <li>
                <a class="dropdown-item" href="{{ route('profile')}}">
                    Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-fw fa-sign-out"></i>&nbsp;
                        Logout
                </a>
            </li>
            @if(Auth::user()->type != 'Registered')
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                
                <a class="dropdown-item" href="{{ route('admin')}}">
                    <i class="fa fa-fw fa-gear"></i>&nbsp;
                    {{ Auth::user()->type }} Panel
                </a>
                
            </li>
            @endif
        </ul>
    </li>
</ul>