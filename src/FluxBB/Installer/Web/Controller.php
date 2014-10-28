<?php

namespace FluxBB\Installer\Web;

use FluxBB\Installer\Installer;
use FluxBB\Web\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    protected $step;

    protected $validation;


    public function index()
    {
        // TODO: Detect where to redirect here, based on state of installation
        return $this->redirect('install_start');
    }

    public function start()
    {
        return $this->view('fluxbb_installer::start');
    }

    public function postStart()
    {
        $rules = [
            // TODO: Verify language being valid
            'language'  => 'required',
        ];

        // TODO: Set bundle (for localization)
        if (!$this->validate($rules)) {
            return $this->redirect('install_start');
        }

        $this->remember('language', $this->getInput('language'));

        return $this->redirect('install_database');
    }

    public function database()
    {
        return $this->view('fluxbb_installer::install_db');
    }

    public function postDatabase()
    {
        $rules = [
            'db_host'   => 'required',
            'db_name'   => 'required',
            'db_user'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->redirect('install_database');
        }

        $db_conf = [
            'driver'    => 'mysql', // FIXME
            'host'      => $this->getInput('db_host'),
            'database'  => $this->getInput('db_name'),
            'username'  => $this->getInput('db_user'),
            'password'  => $this->getInput('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $this->getInput('db_prefix'),
        ];

        $this->remember('db_conf', $db_conf);

        return $this->redirect('install_admin');
    }

    public function admin()
    {
        return $this->view('fluxbb_installer::install_admin');
    }

    public function postAdmin()
    {
        $rules = [
            'username'  => 'required|between:2,25|username_not_guest|no_ip|username_not_reserved|no_bbcode',
            'email'     => 'required|email',
            'password'  => 'required|min:4|confirmed',
        ];

        if (!$this->validate($rules)) {
            return $this->redirect('install_admin');
        }

        $user_info = [
            'username'  => $this->getInput('username'),
            'email'     => $this->getInput('email'),
            'password'  => $this->getInput('password'),
            'ip'        => $this->request->getClientIp(),
        ];

        $this->remember('admin', $user_info);

        return $this->redirect('install_config');
    }

    public function config()
    {
        return $this->view('fluxbb_installer::install_config');
    }

    public function postConfig()
    {
        $rules = [
            'title'         => 'required',
            'description'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->redirect('install_config');
        }

        $board_info = [
            'title'         => $this->getInput('title'),
            'description'   => $this->getInput('description'),
        ];

        $this->remember('board', $board_info);

        return $this->redirect('install_run');
    }

    public function getImportDb()
    {
        return $this->view('fluxbb_installer::import_db');
    }

    public function postImportDb()
    {
        $rules = [
            'db_host'   => 'required',
            'db_name'   => 'required',
            'db_user'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->redirect('install_import');
        }

        $import_db_conf = [
            'driver'    => 'mysql', // FIXME
            'host'      => $this->getInput('db_host'),
            'database'  => $this->getInput('db_name'),
            'username'  => $this->getInput('db_user'),
            'password'  => $this->getInput('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $this->getInput('db_prefix'),
        ];

        $this->remember('import_db_conf', $import_db_conf);

        return $this->redirect('install_import_config');
    }

    public function getImportConfig()
    {
        return $this->view('fluxbb_installer::import_config');
    }

    public function postImportConfig()
    {
        $rules = [
            'title'         => 'required',
            'description'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->redirect('install_import_config');
        }

        $board_info = [
            'title'         => $this->getInput('title'),
            'description'   => $this->getInput('description'),
        ];

        $this->remember('board', $board_info);

        return $this->redirect('install_run');
    }

    public function run()
    {
        return $this->view('fluxbb_installer::run');
    }

    public function postRun()
    {
        $db = $this->retrieve('db_conf');

        // Tell the database to use this connection
        Config::set('database.connections.fluxbb', $db);
        $installer = new Installer(app());
        $installer->setDatabase(app('db')->connection('fluxbb'));

        $installer->writeDatabaseConfig($db);

        $installer->createDatabaseTables();
        $installer->createUserGroups();

        $board = $this->retrieve('board');
        $installer->setBoardInfo($board);

        $admin = $this->retrieve('admin');
        $installer->createAdminUser($admin);

        $installer->createDemoForum();

        return $this->redirect('install_success');
        // TODO: Dump errors
    }

    public function success()
    {
        return $this->view('fluxbb_installer::success');
    }

    protected function validate(array $rules)
    {
        $this->validation = Validator::make($this->input, $rules);
        return $this->validation->passes();
    }

    protected function remember($key, $value)
    {
        Session::put('fluxbb.install.'.$key, $value);
    }

    protected function has($key)
    {
        return Session::has('fluxbb.install.'.$key);
    }

    protected function retrieve($key)
    {
        return Session::get('fluxbb.install.'.$key);
    }
}
