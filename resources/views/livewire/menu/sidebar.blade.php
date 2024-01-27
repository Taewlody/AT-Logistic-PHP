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
</nav>

{{-- @push('script') --}}
@script
    <script>
        // $wire.$on('click', (menu) => {
        //     console.log("click", menu);

        // });

        // Livewire.hook('component.init', ({
        //     component,
        //     cleanup
        // }) => {
        //     console.log("component.init", component);
        // });

        Alpine.data('activeMenu', () => ({
            // var pathArray = window.location.pathname.split('/');
            // console.log("pathArray:", pathArray);
            // return {
            //     activeMenu: pathArray[2],
            //     update(menu) {
            //         if(this.activeMenu == menu){
            //             this.activeMenu = '';
            //             return;
            //         }
            //         this.activeMenu = menu;
            //         // console.log("update", menu);
            //     }
            // }
            listeners: [],
            init() {
                this.activeMenu = window.location.pathname.split('/')[2];
                // this.$watch('activeMenu', (value) => {
                //     this.$dispatch('activeMenu', value);
                // });
                // this.$on('activeMenu', (value) => {
                //     this.activeMenu = value;
                // });
                console.log("init", this.activeMenu);
            },
            update(menu) {
                if (this.activeMenu == menu) {
                    this.activeMenu = '';
                    return;
                }
                this.activeMenu = menu;
                // console.log("update", menu);
            }
        }));
    </script>
@endscript
