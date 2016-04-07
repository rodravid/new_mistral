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

	

	@section('scripts')
	
	<!-- JavaScripts -->
	<script src="{{ asset_web('js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset_web('js/slick.js') }}" type="text/javascript"></script>
	<script src="{{ asset_web('js/jquery.placeholder.js') }}" type="text/javascript"></script>
	<script src="{{ asset_web('js/masked-input.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset_web('js/html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset_web('js/script.js') }}" type="text/javascript"></script>

	@show
</body>
</html>

