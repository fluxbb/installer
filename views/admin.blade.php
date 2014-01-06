@extends('fluxbb_installer::layout.main')

@section('main')

	<!-- begin installer panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Admin User</h3>
		</div>
		<div class="panel-body">
			<p></p>
			<form method="post" role="form">
				
				<div class="form-group">
					<label for="user">Username</label>
					<input class="form-control" type="text" name="username" />
				</div>
				
				<div class="form-group">
					<label for="adminEmail">Email</label>
					<input class="form-control" type="email" name="email"/>
				</div>
				
				<div class="form-group">
					<label for="pass1">Password</label>
					<input class="form-control" type="password" name="password" />
				</div>
				
				<div class="form-group">
					<label for="pass2">Confirm Password</label>
					<input class="form-control" type="password" name="password_confirmation" />
				</div>
				
				<input class="btn btn-primary" type="submit" value="Continue" />
				
			</form>
		</div>
	</div>
	<!-- end installer panel -->


@stop
