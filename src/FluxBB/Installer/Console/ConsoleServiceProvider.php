<?php

namespace FluxBB\Installer\Console;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        $factory = $this->app->make('FluxBB\Console\CommandFactory');
        $installCommand = $factory->make('FluxBB\Installer\Console\InstallCommand');

        $this->app->make('console')->add($installCommand);
    }
}
