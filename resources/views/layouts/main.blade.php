<html>
    
    @push('css')

    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    @livewireStyles

@endpush

@push('script')
    {{-- <script src="/app.js"></script> --}}
    
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <title>@yield('title')</title>
    <title>AT Logistic Management System</title>
    @stack('css')
    @stack('script')

</head>
<body class="pace-done">
    <div class="pace pace-inactive">
        
    </div>
    <div id="wrapper">
        {{-- @include('layouts.menu.sidebar', ['MainMenu' => App\Http\Controllers\layouts\menu\SidebarController::$mainMenu]) --}}
        {{-- @include('layouts.menu.sidebar') --}}
        <livewire:menu.sidebar />
        <div id="page-wrapper" class="gray-bg">
            @include('layouts.menu.navbar')
            @yield('content')
        </div>
    </div>
    @livewireScripts
</body>

</html>