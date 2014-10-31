<?php

namespace FluxBB\Installer\Console;

use FluxBB\Installer\Installer;
use FluxBB\Console\Command;
use FluxBB\Server\Exception\ValidationFailed;

class InstallCommand extends Command
{
    protected $name = 'install';

    protected $description = 'Install FluxBB';

    /**
     * @var \FluxBB\Installer\Installer
     */
    protected $installer;


    public function __construct(Installer $installer)
    {
        parent::__construct();

        $this->installer = $installer;
    }

    protected function fire()
    {
        $this->info('Installing FluxBB...');

        $this->configureDatabase();

        $this->createTablesAndConfig();

        $this->createAdminUser();

        $this->setBoardOptions();

        $this->createDemoContent();

        $this->info('DONE.');
    }

    protected function configureDatabase()
    {
        $configuration = [
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'homestead',
            'username' => 'homestead',
            'password' => 'secret',
            'prefix'   => $this->ask('Table prefix?'),
        ];

        $result = $this->dispatch('write_configuration', $configuration)->getData();

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
            $this->dispatch('handle_registration', [
                'username'              => 'admin',
                'password'              => 'admin',
                'password_confirmation' => 'admin',
                'email'                 => 'admin@admin.org',
                'ip'                    => '127.0.0.1',
            ]);
        } catch (ValidationFailed $e) {
            $this->error('Validation failed for admin user');
        }
    }

    protected function setBoardOptions()
    {
        try {
            $this->dispatch('admin.options.set', [
                'board_title' => 'FluxBB 2.0 Test',
                'board_desc'  => 'Testing the fun.',
            ]);
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
