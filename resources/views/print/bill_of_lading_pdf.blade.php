<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/advance-payment.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/advance-payment.css')}}">
    @endif
</head>

<body>
    <div class="page">
        {{-- TODO: create dpf template --}}
    </div>
</body>
</html>