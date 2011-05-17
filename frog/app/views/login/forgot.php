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
	<h1><?php echo __('Forgot password') .' &ndash; '. Setting::get('admin_title'); ?></h1>

	<form action="<?php echo get_url('login', 'forgot'); ?>" method="post">
		<p id="forgot_line">
			<label for="forgot_email"><?php echo __('Email address'); ?>:</label>
			<input class="input-text" id="forgot_email" type="text" name="forgot[email]" value="<?php echo $email; ?>" tabindex="1" />
		</p>
		
<?php Observer::notify('admin_login_forgot_form'); ?>
		
		<p class="buttons-line">
			<input class="input-button" type="submit" accesskey="s" value="<?php echo __('Send password'); ?>" tabindex="10" title="<?php echo __('Or press'); ?> Alt+S" />
			<span><a href="<?php echo get_url('login'); ?>" tabindex="11"><?php echo __('Login'); ?></a></span>
		</p>
	</form>
</div>