@extends('fluxbb_installer::layout.main')

@section('main')

	<!-- begin installer panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Welcome</h3>
		</div>
		<div class="panel-body">
			<p>Welcome to the FluxBB Installer. This installer is going to guide you throught the
			process of installing FluxBB.</p>
			<form method="post" role="form">
				
				<div class="form-group">
					<label for="language">Installation language</label>
					<select class="form-control" name="language">
						<option value="en">English</option>
					</select>
				</div>
				
				<input class="btn btn-primary" type="submit" value="Start!" />
				
			</form>
		</div>
	</div>
	<!-- end installer panel -->


@stop
