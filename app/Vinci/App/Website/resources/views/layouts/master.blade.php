<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Vinci - Somos loucos por vinho')</title>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vinci.com.br/favicon.ico">
    @section('styles')
        <link rel="stylesheet" href="{{ asset_web('css/style.min.css') }}">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <!--[if IE 8 ]>
        <html lang="en" class="ie8"> <![endif]-->
        <!--[if IE 9 ]>
        <html lang="en" class="ie9"> <![endif]-->
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    @show
</head>
<body ng-app="app">

@yield('content')

@section('scripts')

    <script src="{{ asset_web('js/angular/angular.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/slick.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/readmore.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/input-mask/jquery.inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/input-mask/jquery.inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/jquery.placeholder.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/script.js') }}" type="text/javascript"></script>

    <script src="{{ asset_web('app/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/services/auth.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/loginController.js') }}" type="text/javascript"></script>

@show
</body>
</html>

