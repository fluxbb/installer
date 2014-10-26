<?php

namespace FluxBB\Installer\Console;

use FluxBB\Installer\Installer;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Support\Facades\Config;

class InstallCommand extends Command
{
    protected $name = 'install';

    protected $description = 'Install FluxBB';

    /**
     * @var \FluxBB\Installer\Installer
     */
    protected $installer;

    /**
     * @var \Illuminate\Database\Connectors\ConnectionFactory
     */
    protected $factory;


    public function __construct(Installer $installer, ConnectionFactory $factory)
    {
        parent::__construct();

        $this->installer = $installer;
        $this->factory = $factory;
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

        $connection = $this->makeConnection($db);
        $this->installer->setDatabase($connection);

        $this->installer->writeDatabaseConfig($db);

        $this->installer->createDatabaseTables();
        $this->installer->createUserGroups();

        $board = [
            'title'         => 'FluxBB 2.0 Test',
            'description'   => 'Testing the fun.',
        ];
        $this->installer->setBoardInfo($board);

        $this->installer->createDemoForum();

        $this->info('DONE.');
    }

    protected function makeConnection(array $config)
    {
        return $this->factory->make($config);
    }
}
