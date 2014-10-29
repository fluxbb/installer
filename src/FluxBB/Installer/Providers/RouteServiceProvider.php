<?php

namespace FluxBB\Installer\Providers;

use FluxBB\Server\Server;
use FluxBB\Web\Router;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Add a view namespace for our views
        $this->app->extend('view', function (Factory $view) {
            $view->addNamespace('fluxbb_installer', __DIR__.'/../../../../views/');
            return $view;
        });

        $router = $this->app->make('FluxBB\Web\Router');
        $this->registerRoutes($router);
    }

    /**
     * Register the installation routes.
     *
     * @param \FluxBB\Web\Router $router
     * @return void
     */
    protected function registerRoutes(Router $router)
    {
        $router->get('/install', 'install', 'FluxBB\Installer\Web\Controller@index');
        $router->get('/install/start', 'install_start', 'FluxBB\Installer\Web\Controller@start');
        $router->post('/install/start', 'install_post_start', 'FluxBB\Installer\Web\Controller@postStart');
        $router->get('/install/database', 'install_database', 'FluxBB\Installer\Web\Controller@database');
        $router->post('/install/database', 'install_database_start', 'FluxBB\Installer\Web\Controller@postDatabase');
        $router->get('/install/admin', 'install_admin', 'FluxBB\Installer\Web\Controller@admin');
        $router->post('/install/admin', 'install_post_admin', 'FluxBB\Installer\Web\Controller@postAdmin');
        $router->get('/install/config', 'install_config', 'FluxBB\Installer\Web\Controller@config');
        $router->post('/install/config', 'install_post_config', 'FluxBB\Installer\Web\Controller@postConfig');
        $router->get('/install/run', 'install_run', 'FluxBB\Installer\Web\Controller@run');
        $router->post('/install/run', 'install_post_run', 'FluxBB\Installer\Web\Controller@postRun');
        $router->get('/install/success', 'install_success', 'FluxBB\Installer\Web\Controller@success');
    }
}
