<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Vinci - Somos loucos por vinho')</title>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vinci.com.br/favicon.ico">
    @section('styles')
        <link rel="stylesheet" href="{{ asset_web('css/style.min.css') }}">
        <link rel="stylesheet" href="{{ asset_web('js/sweetalert/sweetalert.css') }}">
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
<body>

@yield('content')

@section('scripts')

    <script src="{{ asset_web('js/angular/angular.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/angular/angular-locale_pt-br.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/angular/angular-counter.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/slick.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/readmore.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/input-mask/jquery.inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/input-mask/jquery.inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/jquery.placeholder.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/common/js/address-autocomplete.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('js/script.js') }}" type="text/javascript"></script>

    <script src="{{ asset_web('app/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/services/auth.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/services/cart.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/home/homeController.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/auth/modalLoginController.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/register/registerController.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/directives/cart/cartItem.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/directives/cart/cartAddButton.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/cart/cartController.js') }}" type="text/javascript"></script>
    <script src="{{ asset_web('app/js/controllers/cart/cartWidgetController.js') }}" type="text/javascript"></script>

@show
</body>
</html>