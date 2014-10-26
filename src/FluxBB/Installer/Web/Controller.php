<?php

namespace FluxBB\Installer\Web;

use FluxBB\Controllers\BaseController;
use FluxBB\Installer\Installer;
use Config;
use DB;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use View;

class Controller extends BaseController
{

    protected $step;

    protected $validation;


    public function run()
    {
        $step = Input::get('step');

        $valid_steps = array('start', 'install_db', 'install_admin', 'install_config', 'import_db', 'import_config', 'run', 'success');
        if (!in_array($step, $valid_steps))
        {
            $step = 'start';
        }

        $this->step = $step;

        $method = strtolower(Request::getMethod());
        $action = $method.'_'.$step;

        return $this->$action();
    }

    public function get_start()
    {
        return View::make('fluxbb_installer::start');
    }

    public function post_start()
    {
        $rules = array(
            // TODO: Verify language being valid
            'language'  => 'required',
        );

        // TODO: Set bundle (for localization)
        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $this->remember('language', Input::get('language'));

        return $this->redirectTo('database');
    }

    public function get_install_db()
    {
        return View::make('fluxbb_installer::install_db');
    }

    public function post_install_db()
    {
        $rules = array(
            'db_host'   => 'required',
            'db_name'   => 'required',
            'db_user'   => 'required',
        );

        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $db_conf = array(
            'driver'    => 'mysql', // FIXME
            'host'      => Input::get('db_host'),
            'database'  => Input::get('db_name'),
            'username'  => Input::get('db_user'),
            'password'  => Input::get('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => Input::get('db_prefix'),
        );

        $this->remember('db_conf', $db_conf);

        return $this->redirectTo('install_admin');
    }

    public function get_install_admin()
    {
        return View::make('fluxbb_installer::install_admin');
    }

    public function post_install_admin()
    {
        $rules = array(
            'username'  => 'required|between:2,25|username_not_guest|no_ip|username_not_reserved|no_bbcode',
            'email'     => 'required|email',
            'password'  => 'required|min:4|confirmed',
        );

        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $user_info = array(
            'username'  => Input::get('username'),
            'email'     => Input::get('email'),
            'password'  => Input::get('password'),
            'ip'        => \Illuminate\Support\Facades\Request::getClientIp(),
        );

        $this->remember('admin', $user_info);

        return $this->redirectTo('install_config');
    }

    public function get_install_config()
    {
        return View::make('fluxbb_installer::install_config');
    }

    public function post_install_config()
    {
        $rules = array(
            'title'         => 'required',
            'description'   => 'required',
        );

        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $board_info = array(
            'title'         => Input::get('title'),
            'description'   => Input::get('description'),
        );

        $this->remember('board', $board_info);

        return $this->redirectTo('run');
    }

    public function get_import_db()
    {
        return View::make('fluxbb_installer::import_db');
    }

    public function post_import_db()
    {
        $rules = array(
            'db_host'   => 'required',
            'db_name'   => 'required',
            'db_user'   => 'required',
        );

        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $import_db_conf = array(
            'driver'    => 'mysql', // FIXME
            'host'      => Input::get('db_host'),
            'database'  => Input::get('db_name'),
            'username'  => Input::get('db_user'),
            'password'  => Input::get('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => Input::get('db_prefix'),
        );

        $this->remember('import_db_conf', $import_db_conf);

        return $this->redirectTo('import_config');
    }

    public function get_import_config()
    {
        return View::make('fluxbb_installer::import_config');
    }

    public function post_import_config()
    {
        $rules = array(
            'title'         => 'required',
            'description'   => 'required',
        );

        if (!$this->validate($rules))
        {
            return $this->redirectBack();
        }

        $board_info = array(
            'title'         => Input::get('title'),
            'description'   => Input::get('description'),
        );

        $this->remember('board', $board_info);

        return $this->redirectTo('run');
    }

    public function get_run()
    {
        return View::make('fluxbb_installer::run');
    }

    public function post_run()
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

        return $this->redirectTo('success');
        // TODO: Dump errors
    }

    public function get_success()
    {
        return View::make('fluxbb_installer::success');
    }


    protected function validate(array $rules)
    {
        $this->validation = Validator::make(Input::all(), $rules);
        return $this->validation->passes();
    }

    protected function redirectTo($step)
    {
        return Redirect::to(Request::url().'?step='.$step);
    }

    protected function redirectBack()
    {
        return $this->redirectTo($this->step)
            ->withInput(Input::all())
            ->withErrors($this->validation->getMessageBag());
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
