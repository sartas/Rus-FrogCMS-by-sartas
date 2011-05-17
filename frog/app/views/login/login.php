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
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */
 
?>

<div id="dialog">
	<h1><?php echo __('Login') .' &ndash; '. Setting::get('admin_title'); ?></h1>
	
	<form action="<?php echo get_url('login/login'); ?>" method="post">
		<input id="login_redirect" type="hidden" name="login[redirect]" value="<?php echo $redirect; ?>" />
		
		<div class="fields-line">
			<p>
				<label for="login_username"><?php echo __('Username'); ?>:</label>
				<input id="login_username" class="input-text" type="text" name="login[username]" value="" tabindex="1" />
			</p>
			
			<p>
				<label for="login_password"><?php echo __('Password'); ?>:</label>
				<input id="login_password" class="input-text" type="password" name="login[password]" value="" tabindex="2" autocomplete="off" />
			</p>
		</div>
		
<?php Observer::notify('admin_login_form'); ?>
		
		<p id="remember_line">
			<input id="login_remember_me" type="checkbox" name="login[remember]" value="checked" tabindex="9" />
			<label for="login_remember_me"><?php echo __('Remember me for 14 days'); ?></label>
		</p>

		<p class="buttons-line">
			<input class="input-button" type="submit" accesskey="s" value="<?php echo __('Login'); ?>" tabindex="10" title="<?php echo __('Or press'); ?> Alt+S" />
			<span><a href="<?php echo get_url('login/forgot'); ?>" tabindex="12"><?php echo __('Forgot password?'); ?></a></span>
		</p>
	</form>
</div>
		