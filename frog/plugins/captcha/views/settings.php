<?php

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
 * @subpackage captcha
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */

?>
<h1><a href="<?php echo get_url('setting/plugin'); ?>"><?php echo __('Plugins'); ?></a> &rarr; <?php echo __('Captcha settings'); ?></h1>

<form action="<?php echo get_url('plugin/captcha/settings'); ?>" method="post" class="dform captcha-settings" id="captcha_settings">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<th colspan="3"><?php echo __('Where you want use captcha?'); ?></th>
			</tr>
			<tr>
				<td class="dform-label"><label for="captcha_login_form"><?php echo __('Protect login form'); ?></label></td>
				<td class="dform-field">
					<select name="captcha_settings[at_login_form]" class="input-select">
						<option value="yes" <?php if(isset($settings['at_login_form']) && $settings['at_login_form'] == 'yes') echo('selected'); ?>><?php echo __('Yes'); ?></option>
						<option value="no" <?php if(isset($settings['at_login_form']) && $settings['at_login_form'] == 'no') echo('selected'); ?>><?php echo __('No'); ?></option>
					</select>
				</td>
				<td class="dform-help"><?php echo __('Captcha will be displayed at login and forgot password pages.'); ?></td>
			</tr>
		</table>
	</div>
	
	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save Changes'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('setting/plugin'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>