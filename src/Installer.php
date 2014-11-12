<?php

namespace FluxBB\Installer;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\ConnectionInterface;

class Installer
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function setDatabase(ConnectionInterface $database)
    {
        $this->database = $database;
        $this->container->instance('Illuminate\Database\ConnectionInterface', $database);
    }

    public function createDemoForum()
    {
        // Create our first category
        $this->database->table('categories')->insert([
            'slug'      => '/',
            'name'      => 'My forum',
            'position'  => 0,
        ]);

        // And a subcategory
        $this->database->table('categories')->insert([
            'slug'      => '/announcements/',
            'name'      => 'Announcements',
            'position'  => 1,
        ]);

        // Create a conversation
        $this->database->table('conversations')->insert([
            'title'         => 'First conversation',
            'category_slug' => '/',
        ]);
    }
}
