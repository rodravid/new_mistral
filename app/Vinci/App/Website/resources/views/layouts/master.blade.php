<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Vinci - Somos loucos por vinho')</title>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vinci.com.br/favicon.ico">
    @section('styles')
    <link rel="stylesheet" href="{{ asset_web('css/style.min.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @show
</head>
<body>
    
    @yield('content')

    @include('website::layouts.footer')
</body>
</html>

