@extends('fluxbb_installer::layout.main')

@section('main')

		<div id="brdinstall" class="installer">

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
							<h5 class="list-group-item-heading">Administration Basics</h5>
							<p class="list-group-item-text">Create the very first account on your board.</p>
						</a>
						<a class="list-group-item">
							<h5 class="list-group-item-heading">Board Meta</h5>
							<p class="list-group-item-text">Settings for your board. You can change this later.</p>
						</a>
					</div>
					<div class="well">
						<h5>Step <strong><span id="progress_step_n">2</strong></span> on <strong><span id="progress_step_of">3</span></strong></h5>
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
								<span class="sr-only">33% Complete</span>
							</div>
						</div>
					</div>
				</div>

				<form class="col-md-8 col-sm-8" method="post" role="form">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h5><span class="icon-cog icon-2x"></span>&nbsp; Administration Basics</h5>
						</div>
						<div class="panel-body">
							<div class="form-horizontal" role="form">
								<div class="form-group">
									<label for="username" class="col-md-4 control-label">Username<span>2 to 25 characters long</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" />
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-md-4 control-label">Email<span></span></label>
									<div class="col-md-8">
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-md-4 control-label">Password<span>At least 4 characters long</span></label>
									<div class="col-md-8">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
									</div>
								</div>
								<div class="form-group">
									<label for="password_confirmation" class="col-md-4 control-label">Password<span>Remember all password are case-sensitive</span></label>
									<div class="col-md-8">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" />
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
