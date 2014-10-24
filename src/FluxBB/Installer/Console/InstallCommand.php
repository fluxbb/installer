<?php

namespace FluxBB\Installer\Console;

use FluxBB\Installer\Installer;
use Illuminate\Console\Command;

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

        $db = [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'homestead',
            'username'  => 'homestead',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $this->ask('Table prefix?'),
        ];
        $this->installer->writeDatabaseConfig($db);

        $this->installer->createDatabaseTables();
        $this->installer->createUserGroups();

        $board = [
            'title'         => 'FluxBB 2.0 Test',
            'description'   => 'Testing the fun.',
        ];
        $this->installer->setBoardInfo($board);

        $admin = [
            'username'  => 'admin',
            'password'  => 'admin',
            'email'     => 'admin@fluxbb.org',
            'ip'        => '127.0.0.1',
        ];
        $this->installer->createAdminUser($admin);

        $this->installer->createDemoForum();

        $this->info('DONE.');
    }
}
