@layout('fluxbb_installer::layout.main')

@section('main')
	<h1>Install FluxBB</h1>
	<p>Be sure to have setup your database connection information in the file <code>application/config/database.php</code>.</p>
	<form action="{{ URL::to_action('fluxbb_installer::home@install') }}" method="post">
		<input type="submit" value="Start!" />
	</form>
@endsection
