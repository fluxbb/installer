<?php

namespace FluxBB\Installer\Console;

use FluxBB\Installer\Installer;
use Illuminate\Database\Connectors\ConnectionFactory;
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
        $installer = new Installer($this->app);
        $factory = new ConnectionFactory($this->app);

        $installCommand = new InstallCommand($installer, $factory);

        $this->app->make('console')->add($installCommand);
    }
}
