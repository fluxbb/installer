<?php

namespace FluxBB\Installer;

use FluxBB\Core\Action;
use Illuminate\Database\ConnectionInterface;

class CreateTables extends Action
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;


    public function __construct(ConnectionInterface $database)
    {
        $this->database = $database;
    }

    protected function run()
    {
        $migrationClasses = [
            'FluxBB\Migrations\Install\Categories',
            'FluxBB\Migrations\Install\Config',
            'FluxBB\Migrations\Install\Conversations',
            'FluxBB\Migrations\Install\ForumPerms',
            'FluxBB\Migrations\Install\ForumSubscriptions',
            'FluxBB\Migrations\Install\Groups',
            'FluxBB\Migrations\Install\GroupPermissions',
            'FluxBB\Migrations\Install\Posts',
            'FluxBB\Migrations\Install\Sessions',
            'FluxBB\Migrations\Install\TopicSubscriptions',
            'FluxBB\Migrations\Install\Users',
        ];

        $schema = $this->database->getSchemaBuilder();
        foreach ($migrationClasses as $class) {
            $instance = new $class($schema);
            $instance->up();
        }
    }
}
