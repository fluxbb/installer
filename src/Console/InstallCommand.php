<?php

namespace FluxBB\Installer\Console;

use FluxBB\Console\Command;
use FluxBB\Server\Exception\ValidationFailed;
use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    protected $name = 'install';

    protected $description = 'Install FluxBB';

    /**
     * @var \FluxBB\Installer\Console\DataProviderInterface
     */
    protected $data;


    protected function getOptions()
    {
        return [
            ['defaults', 'd', InputOption::VALUE_NONE, 'Create default settings and user']
        ];
    }

    protected function fire()
    {
        $this->init();

        $this->info('Installing FluxBB...');

        $this->configureDatabase();

        $this->createTablesAndConfig();

        $this->createAdminUser();

        $this->setBoardOptions();

        $this->createDemoContent();

        $this->info('DONE.');
    }

    protected function init()
    {
        if ($this->option('defaults')) {
            $this->data = new DefaultDataProvider();
        } else {
            $this->data = new UserDataProvider($this->input, $this->output, $this->getHelperSet());
        }
    }

    protected function configureDatabase()
    {
        $configuration = $this->data->getDatabaseConfiguration();
        $configuration['prefix'] = $this->ask('Table prefix:');

        $this->dispatch('write_configuration', $configuration);
    }

    protected function createTablesAndConfig()
    {
        $this->dispatch('create_tables');
        $this->dispatch('create_config');
    }

    protected function createAdminUser()
    {
        try {
            $user = $this->data->getAdminUser();

            $this->dispatch('create_admin_user', $user);
        } catch (ValidationFailed $e) {
            $this->displayErrors($e->getMessageBag());
            $this->createAdminUser();
        }
    }

    protected function setBoardOptions()
    {
        try {
            $options = $this->data->getBoardOptions();

            $this->dispatch('admin.options.set', $options);
        } catch (ValidationFailed $e) {
            $this->displayErrors($e->getMessageBag());
            $this->setBoardOptions();
        }
    }

    protected function createDemoContent()
    {
        $this->dispatch('create_groups');
    }

    protected function displayErrors(MessageBag $errors)
    {
        foreach ($errors->all() as $error) {
            $this->error($error);
        }

        $this->info('Please try again');
    }
}
