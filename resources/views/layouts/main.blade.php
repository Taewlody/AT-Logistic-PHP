<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All meta and title start-->
    @include('layouts.themes.layout.head')
    <!-- meta and title end-->

    <!-- css start-->
    @include('layouts.themes.layout.css')
    @stack('css')
    <!-- css end-->

</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- Loader ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper" >

        <!-- Page Header Start-->
        {{-- @include('themes.layout.header') --}}
        <livewire:menu.navbar />
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            {{-- @include('theme.layout.sidebar') --}}
            <livewire:menu.sidebar />
            <!-- Page Sidebar Ends-->

            <div class="page-body" style="margin-top: 65px;">

                {{-- main body content --}}
                @yield('main-content')

            </div>
            <!-- footer start-->
            @include('layouts.themes.layout.footer')
            <!-- footer end-->
        </div>
    </div>
    <!-- scripts start-->
    @include('layouts.themes.layout.script')
    @stack('scripts')
    <!-- scripts end-->
</body>

</html>
