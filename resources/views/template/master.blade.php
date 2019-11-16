<html>
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
	@include('template.header')
	@yield('content')
</body>
	<script src="{{asset('js/app.js')}}"></script>
</html>