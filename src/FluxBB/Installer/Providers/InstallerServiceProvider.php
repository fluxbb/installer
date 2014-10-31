<?php

namespace FluxBB\Installer\Providers;

use FluxBB\Server\Server;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('fluxbb.server.core', function (Server $server) {
            $server->registerAction('write_configuration', 'FluxBB\Installer\WriteConfiguration');

            return $server;
        });
    }
}
