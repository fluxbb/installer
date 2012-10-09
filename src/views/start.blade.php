@extends('fluxbb_installer::layout.main')

@section('main')

	<p>This installer is going to guide you through the process.</p>
	<form action="{{ URL::route('installer_start') }}" method="POST">
		<label for="language">Installation language</label>
		<select name="language" id="language">
			<option value="en">English</option>
		</select>
		<input type="submit" value="Start!" />
	</form>

@stop
