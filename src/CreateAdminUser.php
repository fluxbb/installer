<?php

namespace FluxBB\Installer;

use FluxBB\Core\Action;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\ConnectionInterface;

class CreateAdminUser extends Action
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;

    /**
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;


    public function __construct(ConnectionInterface $database, Hasher $hasher)
    {
        $this->database = $database;
        $this->hasher = $hasher;
    }

    protected function run()
    {
        $user = [
            'username'          => $this->get('username'),
            'password'          => $this->hasher->make($this->get('password')),
            'email'             => $this->get('email'),
            'group_id'          => 1,
            'registration_ip'   => '127.0.0.1',
        ];

        $this->database->table('users')->insert($user);
    }
}
