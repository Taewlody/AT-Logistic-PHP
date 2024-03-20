{{-- <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul x-data="activeMenu" class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ asset('assets/img/profile_small.jpg') }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->username }}</span>
                        <span class="text-muted text-xs block">User<b class="caret"></b></span>
                    </a>
                </div>
                <div class="logo-element"> ATS</div>
            </li>
            @foreach ($mainMenu as $menu)
                <li :class="{ 'active': activeMenu === '{{ $menu['menu_name'] }}' }">
                    <a href="#" x-on:click="update('{{ $menu['menu_name'] }}')" aria-expanded="false">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span class="nav-label">{{ $menu['name'] }}</span>
                        <span class="fa arrow"></span>
                    </a>
                    @if (array_key_exists('menu', $menu))
                        <ul class="nav nav-second-level collapse"
                            :class="{ 'in': activeMenu === '{{ $menu['menu_name'] }}' }">
                            @foreach ($menu['menu'] as $sub_menu)
                                <li>
                                    <a
                                        href="@if (Route::has($sub_menu['route_name'])) {{ route($sub_menu['route_name']) }} @else # @endif">{{ $sub_menu['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav> --}}

<div class="sidebar-wrapper h-100">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/at-logo.png') }}" alt=""
                    style="width: 96px; height: 35px;">
            </a>
            <div class="back-btn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-left"></i>
            </div>
        </div>

        <div class="logo-icon-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-icon-dark.png') }}"
                    alt="">
            </a>

        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu">

                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-icon-dark.png') }}"
                                alt="">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    @foreach ($mainMenu as $menu)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                {{-- <i data-feather="home"></i> --}}
                                <i class="{{$menu['icon']}}"></i>
                                {{-- {{$menu['name']}} --}}
                                <span>{{$menu['name']}}</span>
                            </a>
                            @if (array_key_exists('menu', $menu))
                                <ul class="sidebar-submenu">
                                    @foreach ($menu['menu'] as $sub_menu)
                                        <li>
                                            <a href="@if (Route::has($sub_menu['route_name'])) {{ route($sub_menu['route_name']) }} @else # @endif">
                                                {{ $sub_menu['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            {{-- <ul class="sidebar-submenu">
                                <li>
                                    <a class="lan-4" href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                            </ul> --}}
                        </li>
                    @endforeach
                </ul>

            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>

{{-- @push('script') --}}
{{-- @script
    <script>
        Alpine.data('activeMenu', () => ({
            listeners: [],
            init() {
                this.activeMenu = window.location.pathname.split('/')[2]; 
                console.log("init", this.activeMenu);
            },
            update(menu) {
                if (this.activeMenu == menu) {
                    this.activeMenu = '';
                    return;
                }
                this.activeMenu = menu;
            }
        }));
    </script>
@endscript --}}
