<nav class="navbar navbar-main navbar-expand-lg navbar-border n-top-header nav-bar-position-fixed" id="navbar-main">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-user d-lg-none ml-auto">
            <ul class="navbar-nav flex-row align-items-center">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin" data-target="#sidenav-main"><i class="fas fa-bars"></i></a>
                </li>

                @if(Auth::user()->type != 'Super Admin' && Auth::user()->type != 'Client')
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link nav-link-icon message-toggle-msg" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope m-0 text-dark"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow p-0">
                        <div class="py-3 px-3">
                            <h5 class="heading h6 mb-0 float-left">{{__('Messages')}}</h5>
                            <a href="#" class="link link-sm mark_all_as_read_message float-right">{{__('Marl All As Read')}}</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="list-group list-group-flush max-380 dropdown-list-message-msg">
                        </div>
                        <div class="py-3 text-center">
                            <a href="{{route('chats')}}" class="link link-sm link--style-3">{{__('View all')}}</a>
                        </div>
                    </div>
                </li>


                @endif

                @if(\Auth::user()->type != 'Super Admin')
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link nav-link-icon notification-toggle
                        {{-- @if(count($notifications))beep @endif --}}
                        " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell m-0 text-dark"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow p-0 notification-dropdown">
                        <div class="py-3 px-3">
                            <h5 class="heading h6 mb-0 float-left">{{__('Notifications')}}</h5>
                            <a href="#" class="link link-sm mark_all_as_read float-right">{{__('Marl All As Read')}}</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="list-group list-group-flush max-380" id="notification-list-mini">

                        </div>
                    </div>
                </li>
                @endif
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="@if(Auth::user()->avatar) {{asset('/storage/avatars/'.Auth::user()->avatar)}} @else {{asset('assets/img/avatar/avatar-1.png')}} @endif">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="dropdown-header px-0">{{__('Hi,')}} {{Auth::user()->name}}!</h6>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>{{__('My Profile')}}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{__('Logout')}}</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse navbar-collapse-fade" id="navbar-main-collapse">
            <ul class="navbar-nav align-items-center d-none d-lg-flex">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin" data-target="#sidenav-main"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media media-pill align-items-center">
                            <span class="avatar rounded-circle">
                                <img src="@if(Auth::user()->avatar) {{asset('/avatars/'.Auth::user()->avatar)}} @else {{asset('assets/img/avatar/avatar-1.png')}} @endif">
                            </span>
                            <div class="ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="dropdown-header px-0">{{__('Hi,')}} {{Auth::user()->name}}!</h6>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>{{__('My Profile')}}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="nav-item">



                </li>

            </ul>

            <ul class="navbar-nav ml-lg-auto align-items-lg-center">


                <li class="nav-item dropdown dropdown-animate">

                    <a class="nav-link nav-link-icon notification-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{--@php
                            echo $time = \Auth::user()->time();
                        @endphp --}}

                    </a>


                </li>


            </ul>
        </div>
    </div>
</nav>