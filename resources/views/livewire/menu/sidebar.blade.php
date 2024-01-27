<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo-dark.png') }}" alt=""></a>
                    <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-left"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo-icon-dark.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""><img
                                class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-icon-dark.png') }}"
                                alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    
                    <li class="sidebar-list"> <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i
                                data-feather="home"></i><span class="lan-3">Dashboard</span><span
                                class="badge badge-primary">2</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="lan-4" href="{{ route('dashboard') }}">Default</a></li>
                            <li><a class="lan-5" href="{{ route('ecommerce_dashboard') }}">Ecommerce</a></li>
                        </ul>
                    </li>
                    @foreach ($mainMenu as $menu)
                        <li @class(['active' => $ActiveMenu == $menu['name']]) wire:click="update('{{ $menu['name'] }}')">
                            <a href="#" aria-expanded="false">
                                <i class="{{ $menu['icon'] }}"></i> 
                                <span class="nav-label">{{ $menu['name'] }}</span>
                                <span class="fa arrow"></span>
                                </a>
                            @if (array_key_exists('menu', $menu))
                                <ul @class(['nav', 'nav-second-level', 'collapse', 'in' => $ActiveMenu == $menu['name']])>
                                    @foreach ($menu['menu'] as $sub_menu)
                                        <li>
                                            <a href="@if (Route::has($sub_menu['route_name'])) {{ $sub_menu['route_name'] }} @else # @endif">{{ $sub_menu['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            {{-- <span class="fa arrow"></span> --}}
                        </li>
                    @endforeach
                    
                </ul>
                
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
