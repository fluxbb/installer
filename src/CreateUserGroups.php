<?php

namespace FluxBB\Installer;

use FluxBB\Core\Action;
use Illuminate\Database\ConnectionInterface;

class CreateUserGroups extends Action
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
        $this->database->table('groups')->insert([
            'id'    => 1,
            'title' => trans('seed_data.administrators'),
        ]);

        $this->database->table('groups')->insert([
            'id'    => 2,
            'title' => trans('seed_data.moderators'),
        ]);

        $this->database->table('groups')->insert([
            'id'    => 4,
            'title' => trans('seed_data.members'),
        ]);
    }
}
