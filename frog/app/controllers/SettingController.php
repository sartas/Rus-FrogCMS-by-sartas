<?php

if ( !defined( 'DEBUG' ) )
	die;

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Maslakov Alexander <jmas.ukraine@gmail.com>
 *
 * This file is part of Frog CMS.
 *
 * Frog CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Frog CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Frog CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Frog CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */
/**
 * @package frog
 * @subpackage controllers
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * Class SettingsController
 *
 * @package frog
 * @subpackage controllers
 *
 * @since 0.8.7
 */
class SettingController extends Controller {

	public function __construct()
	{
		AuthUser::load();
		if ( !AuthUser::isLoggedIn() )
		{
			redirect( get_url( 'login' ) );
		}
		else if ( !AuthUser::hasPermission( 'administrator' ) )
		{
			Flash::set( 'error', __( 'You do not have permission to access the requested page!' ) );

			if ( Setting::get( 'default_tab' ) === 'setting' )
				redirect( get_url( 'page' ) );
			else
				redirect( get_url() );
		}

		$this->setLayout( 'backend' );
	}

	public function index()
	{
		// check if trying to save
		if ( get_request_method() == 'POST' )
			return $this->_save();

		$this->display( 'setting/index', array(
			'filters' => Filter::findAll(),
			'loaded_filters' => Filter::$filters
		) );
	}

	private function _save()
	{
		$data = $_POST['setting'];

		if ( !isset( $data['allow_html_title'] ) )
			$data['allow_html_title'] = 'off';

		if ( !isset( $data['translit_slug'] ) )
			$data['translit_slug'] = 'off';
		else
			$data['translit_slug'] = 'on';


		Setting::saveFromData( $data );

		Flash::set( 'success', __( 'Settings has been saved!' ) );

		redirect( get_url( 'setting' ) );
	}

	public function plugin()
	{
		$this->display( 'setting/plugin', array(
			'plugins' => Plugin::findAll(),
			'loaded_plugins' => Plugin::$plugins
		) );
	}

	public function activate_plugin( $plugin )
	{
		if ( !AuthUser::hasPermission( 'administrator' ) )
		{
			Flash::set( 'error', __( 'You do not have permission to access the requested page!' ) );
			redirect( get_url() );
		}

		Plugin::activate( $plugin );
		Observer::notify( 'plugin_after_enable', $plugin );
	}

	public function deactivate_plugin( $plugin )
	{
		if ( !AuthUser::hasPermission( 'administrator' ) )
		{
			Flash::set( 'error', __( 'You do not have permission to access the requested page!' ) );
			redirect( get_url() );
		}

		Plugin::deactivate( $plugin );
		Observer::notify( 'plugin_after_disable', $plugin );
	}

	// For backward compatibility
	public function getLanguages()
	{
		return I18n::getLanguages();
	}

}

// end SettingController class
