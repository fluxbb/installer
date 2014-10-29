<?php

namespace FluxBB\Installer;

use FluxBB\Core\Action;
use FluxBB\Server\Exception\Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\Filesystem;

class WriteConfiguration extends Action
{
    protected $container;

    protected $files;


    public function __construct(Container $container, Filesystem $filesystem)
    {
        $this->container = $container;
        $this->files = $filesystem;
    }

    protected function run()
    {
        $config = [
            'database' => [
                'driver'    => $this->get('driver'),
                'host'      => $this->get('host'),
                'database'  => $this->get('database'),
                'username'  => $this->get('username'),
                'password'  => $this->get('password'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => $this->get('prefix'),
            ],
            'route_prefix' => '',
        ];

        $file = 'config/fluxbb.php';
        $content = '<?php'."\n\n".'return '.var_export($config, true).';'."\n";

        $success = $this->files->put($file, $content);

        if (!$success) {
            throw new Exception(
                "Unable to write config file. Please create the file '$file' with the following contents:\n\n$config"
            );
        }
    }
}
