<?php

namespace FluxBB\Installer\Web;

use FluxBB\Server\Exception\ValidationFailed;
use FluxBB\Web\Controller as BaseController;

class Controller extends BaseController
{
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
            $this->execute('write.configuration');

            $this->execute('create.tables');
            $this->execute('seed.config');

            return $this->redirectTo('install_admin');
        } catch (ValidationFailed $e) {
            return $this->redirectTo('install_database')
                        ->withInput()
                        ->withErrors($e);
        }
    }

    public function admin()
    {
        return $this->view('fluxbb_installer::install_admin');
    }

    public function postAdmin()
    {
        try {
            $this->execute('seed.admin', [
                'username'  => $this->getInput('username'),
                'password'  => $this->getInput('password'),
                'email'     => $this->getInput('email'),
            ]);

            return $this->redirectTo('install_config');
        } catch (ValidationFailed $e) {
            return $this->redirectTo('install_admin')
                        ->withInput()
                        ->withErrors($e);
        }
    }

    public function config()
    {
        return $this->view('fluxbb_installer::install_config');
    }

    public function postConfig()
    {
        try {
            $this->execute('set.settings'); // TODO: Make sure _ONLY_ title and description are set?

            return $this->redirectTo('install_run');
        } catch (ValidationFailed $e) {
            return $this->redirectTo('install_config')
                        ->withInput()
                        ->withErrors($e);
        }
    }

    public function run()
    {
        return $this->view('fluxbb_installer::run');
    }

    public function postRun()
    {
        $this->execute('seed.groups');

        return $this->redirectTo('install_success');
        // TODO: Dump errors
    }

    public function success()
    {
        return $this->view('fluxbb_installer::success');
    }
}
