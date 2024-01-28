<nav class="navbar-default navbar-static-side" role="navigation">
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
                {{-- <li x-on:click="update('{{$menu['name']}}')" @class(['active' => $ActiveMenu == $menu['name']]) wire:click="update('{{ $menu['name'] }}')"> --}}
                <li :class="{ 'active': activeMenu === '{{ $menu['menu_name'] }}' }">
                    <a href="#" x-on:click="update('{{ $menu['menu_name'] }}')" aria-expanded="false">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span class="nav-label">{{ $menu['name'] }}</span>
                        <span class="fa arrow"></span>
                    </a>
                    @if (array_key_exists('menu', $menu))
                        {{-- <ul @class(['nav', 'nav-second-level', 'collapse', 'in' => $ActiveMenu == $menu['name']])> --}}
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
                    {{-- <span class="fa arrow"></span> --}}
                </li>
            @endforeach
        </ul>
    </div>
</nav>

{{-- @push('script') --}}
@script
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
@endscript
