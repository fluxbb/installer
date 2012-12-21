<?php
/**
 * FluxBB - fast, light, user-friendly PHP forum software
 * Copyright (C) 2008-2012 FluxBB.org
 * based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public license for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category	FluxBB
 * @package		Installer
 * @copyright	Copyright (c) 2008-2012 FluxBB (http://fluxbb.org)
 * @license		http://www.gnu.org/licenses/gpl.html	GNU General Public License
 */

namespace FluxBB\Installer;

use FluxBB\Controllers\Base;
use Config;
use DB;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use View;

class Controller extends Base
{

	protected $step;

	protected $validation;


	public function run()
	{
		$step = Input::query('step');
		// TODO: Input::get()? https://github.com/illuminate/http/pull/7

		$valid_steps = array('start', 'database', 'admin', 'config', 'run', 'success');
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
			'language'	=> 'Required',
		);

		// TODO: Set bundle (for localization)
		if (!$this->validate($rules))
		{
			return $this->redirectBack();
		}

		$this->remember('language', Input::get('language'));

		return $this->redirectTo('database');
	}

	public function get_database()
	{
		return View::make('fluxbb_installer::database');
	}

	public function post_database()
	{
		$rules = array(
			'db_host'	=> 'Required',
			'db_name'	=> 'Required',
			'db_user'	=> 'Required',
		);

		if (!$this->validate($rules))
		{
			return $this->redirectBack();
		}

		$db_conf = array(
			'driver'	=> 'mysql', // FIXME
			'host'		=> Input::get('db_host'),
			'database'	=> Input::get('db_name'),
			'username'	=> Input::get('db_user'),
			'password'	=> Input::get('db_pass'),
			'charset'	=> 'utf8',
			'collation'	=> 'utf8_unicode_ci',
			'prefix'	=> Input::get('db_prefix'),
		);

		$this->remember('db_conf', $db_conf);

		return $this->redirectTo('admin');
	}

	public function get_admin()
	{
		return View::make('fluxbb_installer::admin');
	}

	public function post_admin()
	{
		$rules = array(
			'username'	=> 'Required|Between:2,25|UsernameNotGuest|NoIp|UsernameNotReserved|NoBBcode',
			'email'		=> 'Required|Email',
			'password'	=> 'Required|Min:4|Confirmed',
		);

		if (!$this->validate($rules))
		{
			return $this->redirectBack();
		}

		$user_info = array(
			'username'	=> Input::get('username'),
			'email'		=> Input::get('email'),
			'password'	=> Input::get('password'),
		);

		$this->remember('admin', $user_info);

		return $this->redirectTo('config');
	}

	public function get_config()
	{
		return View::make('fluxbb_installer::config');
	}

	public function post_config()
	{
		$rules = array(
			'title'			=> 'Required',
			'description'	=> 'Required',
		);

		if (!$this->validate($rules))
		{
			return $this->redirectBack();
		}

		$board_info = array(
			'title'			=> Input::get('title'),
			'description'	=> Input::get('description'),
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
		$installer = new Installer(app());

		$db = $this->retrieve('db_conf');

		$installer->writeDatabaseConfig($db);

		// Tell the database to use this connection
		Config::set('database.connections.fluxbb', Config::get('fluxbb.database'));
		DB::setDefaultConnection('fluxbb');

		$installer->createDatabaseTables();
		$installer->createUserGroups();

		$board = $this->retrieve('board');
		$installer->setBoardInfo($board);

		$admin = $this->retrieve('admin');
		$installer->createAdminUser($admin);

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
			->withErrors($this->validation->getMessages());
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
