<!DOCTYPE html>

<html lang="en" dir="ltr">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Install your FluxBB Forum</title>

		{{ $asset('bootstrap', '/vendor/fluxbb/installer/public/css/bootstrap.min.css') }}
		{{ $asset('style', '/vendor/fluxbb/installer/public/css/style.css') }}
		{{ $asset('entypo', '/vendor/fluxbb/installer/public/css/entypo.css') }}

		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400|Telex" rel="stylesheet" type="text/css">

		{!! $assets() !!}

	</head>

	<body id="site-install">

			@yield('main')

	</body>

</html>
