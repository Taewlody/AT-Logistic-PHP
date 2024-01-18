<!DOCTYPE html>
<html>

@push('css')

    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <style type="text/css">
        body {
            background-image: url("{{asset('assets/img/bg.jpg')}}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: left;
        }
    </style>

@endpush

@push('script')
    {{-- <script src="/app.js"></script> --}}
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

<body class="gray-bg" >

    <div class="middle-box text-center loginscreen animated fadeInDown">
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
    </div>
</body>

</html>

