<?php

namespace FluxBB\Installer;

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
            $server->registerAction('write.config', 'FluxBB\Installer\WriteConfiguration');
            $server->registerAction('create.tables', 'FluxBB\Installer\CreateTables');
            $server->registerAction('seed.config', 'FluxBB\Installer\CreateConfig');
            $server->registerAction('seed.admin', 'FluxBB\Installer\CreateAdminUser');
            $server->registerAction('seed.groups', 'FluxBB\Installer\CreateUserGroups');

            return $server;
        });
    }
}
