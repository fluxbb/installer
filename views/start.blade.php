<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Install FluxBB</title>
</head>

<body>

	<h1>Install FluxBB</h1>
	<p>Be sure to have setup your database connection information in the file <code>application/config/database.php</code>.</p>
	<form action="{{ URL::to_action('fluxbb_installer::home@install') }}" method="post">
		<input type="submit" value="Start!" />
	</form>

</body>
</html>
