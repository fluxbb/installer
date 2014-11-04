<?php

namespace FluxBB\Installer\Console;

class DefaultDataProvider implements DataProviderInterface
{
    public function getDatabaseConfiguration()
    {
        return [
            'driver'                => 'mysql',
            'host'                  => 'localhost',
            'database'              => 'homestead',
            'username'              => 'homestead',
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ];
    }

    public function getAdminUser()
    {
        return [
            'username'              => 'admin',
            'password'              => 'admin',
            'password_confirmation' => 'admin',
            'email'                 => 'admin@admin.org',
        ];
    }

    public function getBoardOptions()
    {
        return [
            'board_title' => 'FluxBB 2.0 Test',
            'board_desc'  => 'Testing the fun.',
        ];
    }
}
