<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset_cms("images/favicon.gif") }}">

    <title>CMS Login - Vinci vinhos</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset_cms('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset_cms("fonts/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ asset_cms("css/signin.css") }}" rel="stylesheet">

    <script src="{{ asset_cms('js/jquery.min.js') }}"></script>
    <script src="{{ asset_cms('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset_cms('js/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset_cms('js/login.js') }}"></script>
</head>
<body>
<div class="top-content">
    @yield('content')
</div>
</body>
</html>