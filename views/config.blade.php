@extends('fluxbb_installer::layout.main')

@section('main')

	<!-- begin installer panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Board Configuration</h3>
		</div>
		<div class="panel-body">
			<p></p>
			<form method="post" role="form">
				
				<div class="form-group">
					<label for="boardname">Board name</label>
					<input class="form-control" type="text" name="title" />
				</div>
				
				<div class="form-group">
					<label for="desc">Description</label>
					<input class="form-control" type="text" name="description"/>
				</div>
				
				<input class="btn btn-primary" type="submit" value="Continue" />
				
			</form>
		</div>
	</div>
	<!-- end installer panel -->

@stop
