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

use fluxbb\CLI\TaskRunner,
	fluxbb\Controllers\Base;

class FluxBB_Installer_Home_Controller extends Base
{

	public function __construct()
	{
		parent::__construct();

		if ($this->has('language'))
		{
			Config::set('application.language', $this->retrieve('language'));
		}
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


	public function get_start()
	{
		return View::make('fluxbb_installer::start');
	}

	public function post_start()
	{
		$rules = array(
			// TODO: Verify language being valid
			'language'	=> 'required',
		);

		// TODO: Set bundle (for localization)
		$validation = $this->make_validator(Input::all(), $rules);
		if ($validation->fails())
		{
			return Redirect::to_action('fluxbb_installer::home@start')->with_input()->with_errors($validation);
		}

		$this->remember('language', Input::get('language'));

		return Redirect::to_action('fluxbb_installer::home@database');
	}

	public function get_database()
	{
		return View::make('fluxbb_installer::database');
	}

	public function post_database()
	{
		$rules = array(
			'db_host'	=> 'required',
			'db_name'	=> 'required',
			'db_user'	=> 'required',
		);

		$validation = $this->make_validator(Input::all(), $rules);
		if ($validation->fails())
		{
			return Redirect::to_action('fluxbb_installer::home@database')->with_input()->with_errors($validation);
		}

		return Redirect::to_action('fluxbb_installer::home@admin');
	}

	public function get_admin()
	{
		return View::make('fluxbb_installer::admin');
	}

	public function post_admin()
	{
		$rules = array(
			'username'	=> 'required|between:2,25|username_not_guest|no_ip|username_not_reserved|no_bbcode',
			'email'		=> 'required|email',
			'password'	=> 'required|min:4|confirmed',
		);

		$validation = $this->make_validator(Input::all(), $rules);
		if ($validation->fails())
		{
			return Redirect::to_action('fluxbb_installer::home@admin')->with_input()->with_errors($validation);
		}

		return Redirect::to_action('fluxbb_installer::home@config');
	}

	public function get_config()
	{
		return View::make('fluxbb_installer::config');
	}

	public function post_config()
	{
		$rules = array(
			'title'			=> 'required',
			'description'	=> 'required',
		);

		$validation = $this->make_validator(Input::all(), $rules);
		if ($validation->fails())
		{
			return Redirect::to_action('fluxbb_installer::home@config')->with_input()->with_errors($validation);
		}

		return Redirect::to_action('fluxbb_installer::home@run');
	}

	public function get_run()
	{
		return View::make('fluxbb_installer::run');
	}

	public function post_run()
	{
		$installer = new TaskRunner('fluxbb::install');

		//if ($installer->run())
		{
			return View::make('fluxbb_installer::success')->with('output', $installer->get_output());
		}

		// TODO: Dump errors
	}

}
