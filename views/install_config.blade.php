@extends('fluxbb_installer::layout.main')

@section('main')

		<div id="brdinstall" class="installer">

			<img src="/vendor/fluxbb/installer/public/img/logo_320.png" alt="FluxBB2" />

			<div id="instx" class="box clearfix">

				<h3 class="col-md-12 col-sm-12">Welcome to FluxBB 2.0 Installer!</h3><br />

				<div class="col-md-4 col-sm-4">
					<div class="list-group">
						<a href="#" class="list-group-item active">
							<h5 class="list-group-item-heading">Database Setup</h5>
							<p class="list-group-item-text">All information we need to create a connection with your database.</p>
						</a>
						<a href="#" class="list-group-item">
							<h5 class="list-group-item-heading">Administration Basics</h5>
							<p class="list-group-item-text">Create the very first account on your board.</p>
						</a>
						<a href="#" class="list-group-item">
							<h5 class="list-group-item-heading">Board Meta</h5>
							<p class="list-group-item-text">Settings for your board. You can change this later.</p>
						</a>
					</div>
					<div class="well">
						<h5>Step <strong><span id="progress_step_n">3</strong></span> on <strong><span id="progress_step_of">3</span></strong></h5>
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
								<span class="sr-only">66% Complete</span>
							</div>
						</div>
					</div>
				</div>

				<form class="col-md-8 col-sm-8" method="post" role="form">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h5><span class="icon-brush icon-2x"></span>&nbsp; Board Meta</h5>
						</div>
						<div class="panel-body">
							<div class="form-horizontal" role="form">
								<div class="form-group">
									<label for="title" class="col-md-4 control-label">Board title<span>Find some catchy title</span></label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="title" name="board_title" placeholder="My FluxBB2 Forum" />
									</div>
								</div>
								<div class="form-group">
									<label for="description" class="col-md-4 control-label">Board description<span>HTML is allowed here.</span></label>
									<div class="col-md-8">
										<textarea class="form-control" id="description" name="board_desc" placeholder="Unfortunately no one can be told what FluxBB is - you have to see it for yourself."></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="default_lang" class="col-md-4 control-label">Default language<span></span></label>
									<div class="col-md-8">
										<select class="form-control" id="default_lang" name="default_lang">
											<option value="English" selected="selected">English</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-4 control-label">Default style<span>Look 'n Feel</span></label>
									<div class="col-md-8">
										<div class="col-md-6 text-center">
											<img class="img-thumbnail" src="/vendor/fluxbb/installer/public/img/RD_demo.png" alt="" width="128" height="" />
											<input type="radio" id="default_style" name="default_style" value="FluxBB2" checked />
										</div>
										<div class="col-md-6 text-center">
											<img class="img-thumbnail" src="/vendor/fluxbb/installer/public/img/Air_demo.png" alt="" width="128" height="" />
											<input type="radio" id="default_style" name="default_style" value="Air" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<p class="clearfix">
						<a href="javascript:history.go(-1)" class="btn btn-danger pull-left">← Previous Step</a>
						<input type="submit" class="btn btn-success pull-right" value="Next Step →" />
					</p>

				</form>

			</div>

		</div>


@stop
