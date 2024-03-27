<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>page not found</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/css/vendors/bootstrap/bootstrap.css')}}">
        <!-- Styles -->
        
    </head>
    <body>
        <div class="middle-box text-center animated fadeInDown">
            <h1>404</h1>
            <a class="font-bold btn btn-primary mb-2" href="{{ url()->previous() }}">Page Not Found</a>

            <div class="error-desc">
                Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
            
            </div>
        </div>
    </body>
</html>