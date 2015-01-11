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

    public function fire()
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

        $this->dispatch('write.config', $configuration);
    }

    protected function createTablesAndConfig()
    {
        $this->dispatch('create.tables');
        $this->dispatch('seed.config');
    }

    protected function createAdminUser()
    {
        try {
            $user = $this->data->getAdminUser();

            $this->dispatch('seed.admin', $user);
        } catch (ValidationFailed $e) {
            $this->displayErrors($e->getMessageBag());
            $this->createAdminUser();
        }
    }

    protected function setBoardOptions()
    {
        try {
            $options = $this->data->getBoardOptions();

            $this->dispatch('set.settings', $options);
        } catch (ValidationFailed $e) {
            $this->displayErrors($e->getMessageBag());
            $this->setBoardOptions();
        }
    }

    protected function createDemoContent()
    {
        $this->dispatch('seed.groups');
    }

    protected function displayErrors(MessageBag $errors)
    {
        foreach ($errors->all() as $error) {
            $this->error($error);
        }

        $this->info('Please try again');
    }
}
