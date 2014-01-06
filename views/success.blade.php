@extends('fluxbb_installer::layout.main')

@section('main')

	<div class="alert alert-success">
		<strong>Installation successful!</strong>
		<p>You can now <a href="{{ route('index') }}">visit your forum index</a>.</p>
	</div>

@stop
