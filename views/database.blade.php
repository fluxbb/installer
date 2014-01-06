@extends('fluxbb_installer::layout.main')

@section('main')


	<!-- begin installer panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Database Configuration</h3>
		</div>
		<div class="panel-body">
			<p></p>
			<form method="post" role="form">
				
				<div class="form-group">
					<label for="dbhost">Host</label>
					<input class="form-control" type="text" name="db_host" />
				</div>
				
				<div class="form-group">
					<label for="dbname">Name</label>
					<input class="form-control" type="text" name="db_name" />
				</div>
				
				<div class="form-group">
					<label for="dbuser">User</label>
					<input class="form-control" type="text" name="db_user" />
				</div>
				
				<div class="form-group">
					<label for="dbpass">Password</label>
					<input class="form-control" type="password" name="db_pass" />
				</div>
				
				<div class="form-group">
					<label for="dbprefix">Table prefix</label>
					<input class="form-control" type="text" value="fluxbb_" name="db_prefix"/>
				</div>
				
				<input class="btn btn-primary" type="submit" value="Continue" />
				
			</form>
		</div>
	</div>
	<!-- end installer panel -->


@stop
