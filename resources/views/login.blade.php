<!DOCTYPE html>
<html>

@push('css')

    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">


<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-2.css') }}" media="screen">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
@endpush

@push('script')
    {{-- <script src="/app.js"></script> --}}
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush   

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <title>AT Logistic | Login</title>

    @stack('css')
    @stack('script')

</head>

<body>

    {{-- <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">AT</h1>

            </div>
            <h3>Logistic Management System</h3>
   
            <p>Login in. To see it in action.</p>
            <form class="m-t" id="m-t" name="form1" role="form"  autocomplete="off" method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" autocomplete="off" id="username" name="username" required=true>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password"  autocomplete="new-password" id="password" name="password" required=true>
                </div>
                {{ csrf_field() }}
                <button type="submit" name="btnSubmit" class="btn btn-primary block full-width m-b">Login</button>
            </form>

            
   
        </div>
    </div> --}}

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <div>
                            <div class="logo"><img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/at-logo.png') }}" alt="logo image" width="200px" height="200px"></div>
                            <div class="login-main">
                                <form class="theme-form" method="post" action="" enctype="multipart/form-data">
                                    <h4 class="text-center">Logistic Management System</h4>
                                    <p class="text-center">Login in. To see it in action.</p>
                                    <div class="form-group">
                                        <label class="col-form-label">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" autocomplete="off" id="username" name="username" required=true>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Password</label>
                                        <div class="form-input position-relative">
                                            <input type="password" class="form-control" placeholder="Password"  autocomplete="new-password" id="password" name="password" required=true>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="checkbox p-0">
                                            {{ csrf_field() }}
                                            <button type="submit" name="btnSubmit" class="btn btn-primary btn-block w-100" type="submit">Sign in </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>

