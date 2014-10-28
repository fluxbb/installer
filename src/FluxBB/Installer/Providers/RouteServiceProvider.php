<?php

namespace FluxBB\Installer\Providers;

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
    {}

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Add a view namespace for our views
        $this->app->extend('view', function (Factory $view) {
            $view->addNamespace('fluxbb_installer', __DIR__.'/../../../views/');
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
        $router->get('/install', 'install', 'FluxBB\Installer\Web\Controller@run');
        $router->post('/install', 'post_install', 'FluxBB\Installer\Web\Controller@run');
    }
}
