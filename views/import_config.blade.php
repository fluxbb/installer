@extends('fluxbb_installer::layout.main')

@section('main')

		<div id="brdimport" class="installer">

			<img src="{{ URL::asset('packages/fluxbb/installer/img/logo_320.png') }}" alt="FluxBB2" />

			<div id="instx" class="box clearfix">

				<h3 class="col-md-12 col-sm-12">Welcome to FluxBB 2.0 Installer!</h3><br />

				<div class="col-md-4 col-sm-4">
					<div class="list-group">
						<a class="list-group-item">
							<h5 class="list-group-item-heading">Database Setup</h5>
							<p class="list-group-item-text">All information we need to create a connection with your database.</p>
						</a>
						<a class="list-group-item active">
							<h5 class="list-group-item-heading">Import an existing Forum</h5>
							<p class="list-group-item-text">Import all Posts, Topics, Users… From an already existing Forum.</p>
						</a>
					</div>
					<div class="well">
						<h5>Step <strong>2</strong> on <strong>2</strong></h5>
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="500" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								<span class="sr-only">50% Complete</span>
							</div>
						</div>
					</div>
				</div>

				<form class="col-md-8 col-sm-8" method="post" role="form">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h5><span class="icon-download icon-2x"></span>&nbsp; Import an existing Forum</h5>
						</div>
						<div class="panel-body">
							<div class="form-horizontal" role="form">
								<div class="form-group">
									<label for="import_url" class="col-md-4 control-label">URL<span>Where is your Forum?</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="import_url" name="import_url" placeholder="http://myawesomeforum.com" />
									</div>
								</div>
								<div class="form-group">
									<label for="import_type" class="col-md-4 control-label">Forum Software<span>Which type of Forum is it?</span></label>
									<div class="col-md-4">
										<select class="form-control" id="import_type" name="import_type">
											<option value="">PunBB</option>
											<option value="">MyBB</option>
											<option value="">PhpBB</option>
											<option value="">iPB (Invision Power Board)</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="import_dbhost" class="col-md-4 control-label">Server Hostname<span>Existing Forum's Server name</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="import_dbhost" name="import_dbhost" value="" placeholder="localhost" />
									</div>
								</div>
								<div class="form-group">
									<label for="import_dbname" class="col-md-4 control-label">Name<span>Existing Forum's Database Name</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="import_dbname" name="import_dbname" value="" placeholder="fluxbb" />
									</div>
								</div>
								<div class="form-group">
									<label for="import_dbuser" class="col-md-4 control-label">Username<span>Existing Forum's Username</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="import_dbuser" name="import_dbuser" placeholder="Username" />
									</div>
								</div>
								<div class="form-group">
									<label for="import_dbpass" class="col-md-4 control-label">Password<span>Existing Forum's Password</span></label>
									<div class="col-md-8">
										<input type="password" class="form-control" id="import_dbpass" name="import_dbpass" placeholder="Password" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<p class="clearfix">
						<a href="javascript:history.go(-1)" class="btn btn-danger pull-left">← Previous Step</a>
						<input type="submit" class="btn btn-success pull-right" name="save" value="Next Step →" />
					</p>

				</form>

			</div>

		</div>

@stop
