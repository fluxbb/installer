<?php

namespace FluxBB\Installer\Web;

use FluxBB\Installer\Installer;
use FluxBB\Server\Exception\ValidationFailed;
use FluxBB\Web\Controller as BaseController;

class Controller extends BaseController
{
    protected $installer;


    public function __construct(Installer $installer)
    {
        $this->installer = $installer;
    }

    public function index()
    {
        // TODO: Detect where to redirect here, based on state of installation
        return $this->redirectTo('install_start');
    }

    public function start()
    {
        return $this->view('fluxbb_installer::start');
    }

    public function database()
    {
        return $this->view('fluxbb_installer::install_db');
    }

    public function postDatabase()
    {
        try {
            $this->execute('write_configuration');

            $this->installer->setDatabase($this->getConnection());
            $this->installer->createDatabaseTables();
            $this->installer->createConfig();

            return $this->redirectTo('install_admin');
        } catch (ValidationFailed $e) {
            return $this->errorRedirectTo('install_database', $e);
        }
    }

    public function admin()
    {
        return $this->view('fluxbb_installer::install_admin');
    }

    public function postAdmin()
    {
        try {
            $this->execute('create_admin_user', [
                'username'  => $this->getInput('username'),
                'password'  => $this->getInput('password'),
                'email'     => $this->getInput('email'),
            ]);

            return $this->redirectTo('install_config');
        } catch (ValidationFailed $e) {
            return $this->errorRedirectTo('install_admin', $e);
        }
    }

    public function config()
    {
        return $this->view('fluxbb_installer::install_config');
    }

    public function postConfig()
    {
        try {
            $this->execute('admin.options.set'); // TODO: Make sure _ONLY_ title and description are set?

            return $this->redirectTo('install_run');
        } catch (ValidationFailed $e) {
            return $this->errorRedirectTo('install_config', $e);
        }
    }

    public function run()
    {
        return $this->view('fluxbb_installer::run');
    }

    public function postRun()
    {
        $this->installer->setDatabase($this->getConnection());
        $this->installer->createUserGroups();
        $this->installer->createDemoForum();

        return $this->redirectTo('install_success');
        // TODO: Dump errors
    }

    public function success()
    {
        return $this->view('fluxbb_installer::success');
    }

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function getConnection()
    {
        return app()->make('Illuminate\Database\ConnectionInterface');
    }
}
