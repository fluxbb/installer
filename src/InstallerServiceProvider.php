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
            $server->registerAction('write_configuration', 'FluxBB\Installer\WriteConfiguration');
            $server->registerAction('create_tables', 'FluxBB\Installer\CreateTables');
            $server->registerAction('create_admin_user', 'FluxBB\Installer\CreateAdminUser');
            $server->registerAction('create_groups', 'FluxBB\Installer\CreateUserGroups');

            return $server;
        });
    }
}
