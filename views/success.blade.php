@extends('fluxbb_installer::layout.main')

@section('main')

		<div id="brdinstall" class="installer">

			<img src="{{ URL::asset('packages/fluxbb/installer/img/logo_320.png') }}" alt="FluxBB2" />

			<div id="instx" class="box">

				<h2>Awesomeness ensues!</h2>
				<p>Everything went smooth, your brand new FluxBB 2 Forum is up and running! A notification email has been sent to you to confirm that. You can now <a href="{{ $route('admin.index') }}">go to the Dashboard</a> and start customizing your Forum, or <a href="{{ $route('admin.index') }}">take the tour</a> and discover all the new features from FluxBB 2.</p>
				<div class="btn-group">
					<a class="btn btn-success" href="{{ $route('index') }}">Let's Rock! <span class="icon-right"></span></a>
				</div>

			</div>

		</div>

@stop
