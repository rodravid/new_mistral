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

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset_cms('bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ asset_cms("dist/css/login.css") }}" rel="stylesheet">

    <script src="{{ asset_cms('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset_cms('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset_cms('plugins/backstretch/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset_cms('dist/js/login.js') }}"></script>
</head>
<body>
<div class="top-content">
    @yield('content')
</div>
</body>
</html>