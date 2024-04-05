<div class="sidenav custom-sidenav" id="sidenav-main">
    <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('assets/images/logo.png')}}" alt="{{ config('app.name', 'LeadGo') }}" class="navbar-brand-img">
        </a>
        <div class="ml-auto">
            <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="scrollbar-inner">
        <div class="div-mega">
            <ul class="navbar-nav navbar-nav-docs">
                @if((\Auth::user()->type != 'Owner'))
                <li class="nav-item" style="font-weight: 400;">{{ Auth::user()->org_name }}</li>
                @endif
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{ (Request::route()->getName() == 'home') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>{{__('Dashboard')}}
                    </a>
                </li>

                @if (\Auth::user()->can('Management'))
                <!-- Management SECTION -->
                <li class="nav-item {{ (Request::route()->getName() == 'management.user' || Request::route()->getName() == 'management.revShare' || Request::route()->getName() == 'management.companyAssign'  || Request::route()->getName() == 'management.company' || Request::route()->getName() == 'management.currency' || Request::route()->getName() == 'management.operator' || Request::route()->getName() == 'users') ? 'active' : 'collapsed' }}">
                    @can('Management')
                    <a class="nav-link collapsed" href="#navbar-getting-started-management" data-toggle="collapse" role="button" aria-expanded="{ (Request::route()->getName() == 'management.user') ? 'true' : 'false' }}" aria-controls="navbar-getting-started-management">
                        <i class="fas fa-users"></i>{{__('Management')}}
                        <i class="fas fa-sort-up"></i>
                    </a>
                    @endcan
                    <div class="collapse {{ (Request::route()->getName() == 'management.user' || Request::route()->getName() == 'management.revShare' || Request::route()->getName() == 'management.companyAssign' || Request::route()->getName() == 'management.company' || Request::route()->getName() == 'management.currency' || Request::route()->getName() == 'management.operator' || Request::route()->getName() == 'project.management' || Request::route()->getName() == 'users' )  ? 'show' : '' }}" id="navbar-getting-started-management">
                        <ul class="nav flex-column submenu-ul">
                          
                            @if(Gate::check('Manage Users') || Gate::check('Manage Clients') || Gate::check('Manage Roles') || Gate::check('Manage Permissions'))
                            @if((\Auth::user()->type == 'Business Owner') || (\Auth::user()->type == 'Administrator') || (\Auth::user()->type == 'Owner'))
                            @can('Manage Users')
                            <li class="nav-item  {{ Request::route()->getName() == 'users' ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('users')}}">
                                    {{__(' Staff Management')}}
                                </a>
                            </li>
                            @endcan
                            @endif
                            @endif
                          
                          
            </ul>
        </div>
        </li>
        @endif
        @if((\Auth::user()->type == 'Owner'))
        @can('Manage Roles')
        <li class="nav-item">
            <a class="nav-link {{ (Request::route()->getName() == 'roles.index') ? 'active' : '' }}" href="{{route('roles.index')}}">
                <i class="fas fa-user-cog"></i>{{__('Roles')}}
            </a>
        </li>
        @endcan
        @endif


        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>{{__('Logout')}}</span>
            </a>
        </li>
        </ul>
    </div>
</div>
</div>