<?php

namespace FluxBB\Installer;

use FluxBB\Core;
use FluxBB\Core\Action;
use Illuminate\Database\ConnectionInterface;

class CreateConfig extends Action
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
        $config = [
            'o_cur_version'             => Core::version(),
            'o_board_title'             => '',
            'o_board_desc'              => '',
            'o_time_format'             => 'H:i:s',
            'o_date_format'             => 'Y-m-d',
            'o_show_version'            => 0,
            'o_default_user_group'      => 4,
        ];

        foreach ($config as $name => $value) {
            $this->database->table('config')->insert([
                'conf_name'     => $name,
                'conf_value'    => $value,
            ]);
        }
    }
}
