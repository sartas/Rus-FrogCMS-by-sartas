<?php if(!defined('DEBUG')) die;

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

class FrontController extends Controller
{
	public function index()
	{		
		Observer::notify( 'page_requested', CURRENT_URI );
		
		// this is where 80% of the things is done
		$__PAGE__ = FrontPage::find( CURRENT_URI );
		
		 // if we fund it, display it!
		if( $__PAGE__ !== false && $__PAGE__ !== null )
		{
			// If page needs login, redirect to login
			if( $__PAGE__->getLoginNeeded() == Page::LOGIN_REQUIRED )
			{
				AuthUser::load();
				
				if( !AuthUser::isLoggedIn() )
				{
					Flash::set( 'redirect', $__PAGE__->url() );
					
					redirect( URL_PUBLIC . ADMIN_DIR . ( USE_MOD_REWRITE ? '/' : '/?/' ) . 'login' );
				}
			}
			
			Observer::notify( 'page_found', $__PAGE__ );
			
			$__PAGE__->display();
		}
		else
		{
			$this->page_not_found();
		}
	}
	
	public static function page_not_found()
	{
		page_not_found();
	}
}