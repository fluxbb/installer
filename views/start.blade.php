@extends('fluxbb_installer::layout.main')

@section('main')

		<div id="brdinstall">

			<img src="{{ URL::asset('packages/fluxbb/installer/img/logo_320.png') }}" alt="FluxBB2" />

			<div id="instx" class="box">

				<h4>Welcome to FluxBB 2.0!</h4>
				<p>FluxBB 2 is a fast, light, user-friendly and extendable Forum Software. <strong>What would you like to do?</strong></p>
				<div class="btn-group">
					<a class="btn btn-primary" href="?step=install_db"><span class="icon-install"></span> Install from Scratch</a>
					<span class="junction"><small>or</small></span>
					<a class="btn btn-primary" href="?step=import_db"><span class="icon-cycle"></span> Import my old Forum</a>
				</div>

			</div>

		</div>


@stop
