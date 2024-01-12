<!DOCTYPE html>
<html>
    
    @push('css')

    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

@endpush

@push('script')
    <script src="/app.js"></script>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @stack('css')
    @stack('script')

</head>
<body>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
              <li class="nav-header">
                <div class="dropdown profile-element"> <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="block m-t-xs font-bold">{{Auth::user()->username}}</span> <span class="text-muted text-xs block">User<b class="caret"></b></span> </a>
             
                    
                </div>
                <div class="logo-element"> ATS</div>
              </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    
</body>

</html>