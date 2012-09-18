@layout('fluxbb_installer::layout.main')

@section('main')
	<h1>Installation successful</h1>
	<h2>Script output:</h2>
	<pre>{{ e($output) }}</pre>
@endsection
