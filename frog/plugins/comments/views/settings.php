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
 * @subpackage comments
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */

?>
<h1><a href="<?php echo get_url('setting/plugin'); ?>"><?php echo __('Plugins'); ?></a> &rarr; <?php echo __('Comments settings'); ?></h1>

<form action="<?php echo get_url('plugin/comments/settings'); ?>" method="post" class="dform comments-settings" id="comments_settings">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<th colspan="3"><?php echo __('General settings'); ?></th>
			</tr>
			<tr>
				<td class="dform-label"><label for="comments_login_form"><?php echo __('Auto approve'); ?></label></td>
				<td class="dform-field">
					<select name="comments_settings[auto_approve]" class="input-select">
						<option value="yes" <?php if(isset($settings['auto_approve']) && $settings['auto_approve'] == 'yes') echo('selected'); ?>><?php echo __('Yes'); ?></option>
						<option value="no" <?php if(isset($settings['auto_approve']) && $settings['auto_approve'] == 'no') echo('selected'); ?>><?php echo __('No'); ?></option>
					</select>
				</td>
				<td class="dform-help"><?php echo __('Choose yes if you want your comments to be auto approved. Otherwise, they will have status "Not approved".'); ?></td>
			</tr>
			<tr>
                <td class="dform-label"><label for="use_captcha"><?php echo __('Use captcha'); ?></label></td>
                <td class="dform-field">
					<select name="comments_settings[use_captcha]" class="input-select">
						<option value="yes" <?php if(isset($settings['use_captcha']) && $settings['use_captcha'] == 'yes') echo('selected'); ?>><?php echo __('Yes'); ?></option>
						<option value="no" <?php if(isset($settings['use_captcha']) && $settings['use_captcha'] == 'no') echo('selected'); ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
                <td class="dform-help"><?php echo __('Choose yes if you want to use a captcha to protect yourself against spammers.'); ?></td>
            </tr>
		</table>
	</div>
	
	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save Changes'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('setting/plugin'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>