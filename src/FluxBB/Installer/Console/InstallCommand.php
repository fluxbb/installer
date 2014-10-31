<?php

namespace FluxBB\Installer\Console;

use FluxBB\Installer\Installer;
use FluxBB\Console\Command;
use FluxBB\Server\Exception\ValidationFailed;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    protected $name = 'install';

    protected $description = 'Install FluxBB';

    /**
     * @var \FluxBB\Installer\Installer
     */
    protected $installer;

    /**
     * @var \FluxBB\Installer\Console\DataProviderInterface
     */
    protected $data;


    public function __construct(Installer $installer)
    {
        parent::__construct();

        $this->installer = $installer;
    }

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
        $configuration['prefix'] = $this->ask('Table prefix?');

        $result = $this->dispatch('write_configuration', $configuration);

        $connection = $result['connection'];
        $this->installer->setDatabase($connection);
    }

    protected function createTablesAndConfig()
    {
        $this->installer->createDatabaseTables();
        $this->installer->createConfig();
    }

    protected function createAdminUser()
    {
        try {
            $user = $this->data->getAdminUser();
            $user['ip'] = '127.0.0.1';

            $this->dispatch('handle_registration', $user);
        } catch (ValidationFailed $e) {
            $this->error('Validation failed for admin user');
        }
    }

    protected function setBoardOptions()
    {
        try {
            $options = $this->data->getBoardOptions();

            $this->dispatch('admin.options.set', $options);
        } catch (ValidationFailed $e) {
            $this->error('Validation failed for board options');
        }
    }

    protected function createDemoContent()
    {
        $this->installer->createUserGroups();
        $this->installer->createDemoForum();
    }
}
