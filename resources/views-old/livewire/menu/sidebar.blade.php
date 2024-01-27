<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
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
</nav>

{{-- @push('script') --}}
@script
    <script>
        $wire.$on('click', (menu) => {
            console.log("click", menu);
        });

        Livewire.hook('component.init', ({
            component,
            cleanup
        }) => {
            console.log("component.init", component);
        });

        Alpine.data()
    </script>
@endscript
