@layout('fluxbb_installer::layout.main')

@section('main')

	<h2>Run</h2>

	<form method="POST">
		<p>You're ready to run the FluxBB installation.</p>
		<p>TODO: Review information here.</p>
		<pre><?php print_r(Session::get('fluxbb.install')); ?></pre><br>
		<input type="submit" value="Weiter" />
	</form>

@endsection
