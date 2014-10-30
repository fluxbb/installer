@extends('fluxbb_installer::layout.main')

@section('main')

        <div id="brdinstall" class="installer">

            <img src="/public/packages/fluxbb/installer/img/logo_320.png" alt="FluxBB2" />

            <div id="instx" class="box">

                <h4>Last step</h4>
                <p>We are almost there. One more step to go.</p>
                <form method="post" role="form">
                    <p class="clearfix">
                        <a href="javascript:history.go(-1)" class="btn btn-danger pull-left">← Previous Step</a>
                        <input type="submit" class="btn btn-success pull-right" name="save" value="Run →" />
                    </p>
                </form>

            </div>

        </div>


@stop
