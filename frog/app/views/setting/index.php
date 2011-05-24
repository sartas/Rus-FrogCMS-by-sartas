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
<h1><?php echo __('General settings'); ?></h1>

<form action="<?php echo get_url('setting'); ?>" method="post" class="dform settings" id="settings">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<th colspan="3"><?php echo __('Site options'); ?></th>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_admin_title"><?php echo __('Admin Site title'); ?></label></td>
				<td class="dform-field"><input class="input-text" id="setting_admin_title" maxlength="255" name="setting[admin_title]" size="255" type="text" value="<?php echo htmlentities(Setting::get('admin_title'), ENT_COMPAT, 'UTF-8'); ?>" /></td>
				<td class="dform-help"><?php echo __('By using <strong>&lt;img src="img_path" /&gt;</strong> you can set your company logo instead of a title.'); ?></td>
			</tr>
<?php /*
			<tr>
				<td class="dform-label"><label for="setting_language"><?php echo __('General site language'); ?></label></td>
				<td class="dform-field">
					<select class="input-select" id="setting_language" name="setting[language]">
						<?php $current_language = Setting::get('language'); ?>
						<?php foreach( I18n::getLanguages() as $code => $label ): ?>
						<option value="<?php echo $code; ?>"<?php if ($code == $current_language) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td class="dform-help"><?php echo __('This will set your language for the backend.'); ?><br /><?php echo __('Help us <a href=":url">translate Frog</a>!', array(':url' => get_url('translate'))); ?></td>
			</tr>
*/ ?>
			<tr>
				<td class="dform-label"><label for="setting_theme"><?php echo __('Administration Theme'); ?></label></td>
				<td class="dform-field">
					<select class="input-select" id="setting_theme" name="setting[theme]" onchange="$('css_theme').href = 'themes/' + this[this.selectedIndex].value + '/styles.css';">
					<?php $current_theme = Setting::get('theme'); ?>
					<?php foreach( Setting::getThemes() as $code => $label ): ?>
						<option value="<?php echo $code; ?>"<?php if ($code == $current_theme) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
					<?php endforeach; ?>
					</select>
				</td>
				<td class="dform-help"><?php echo __('This will change your Administration theme.'); ?></td>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_default_tab"><?php echo __('Default tab'); ?></label></td>
				<td class="dform-field">
					<select class="input-select" id="setting_default_tab" name="setting[default_tab]">
					<?php $current_default_tab = Setting::get('default_tab');?>
						<option value="page" <?php if ($current_default_tab == 'page') echo ('selected="selected"'); ?> ><?php echo __('Pages'); ?></option>
						<option value="snippet" <?php if ($current_default_tab == 'snippet') echo ('selected="selected"'); ?> ><?php echo __('Snippets'); ?></option>
						<option value="layout" <?php if ($current_default_tab == 'layout') echo ('selected="selected"'); ?> ><?php echo __('Layouts'); ?></option>
						<option value="user" <?php if ($current_default_tab == 'user') echo ('selected="selected"'); ?> ><?php echo __('Users'); ?></option>
						<option value="setting" <?php if ($current_default_tab == 'setting') echo ('selected="selected"'); ?> ><?php echo __('Administration'); ?></option>
						
						<?php foreach( Plugin::$controllers as $key => $controller ): ?>
						<?php if( $controller->show_tab === true ): ?>
						<option value="plugin/<?php echo $key; ?>"<?php if ('plugin/'. $key == $current_default_tab) echo ' selected="selected"'; ?>><?php echo __(is_array($controller->label) ? array_pop(array_values($controller->label)) : $controller->label); ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</td>
				<td class="dform-help"><?php echo __('This allows you to specify which tab (controller) you will see by default after login.'); ?></td>
			</tr>
			<tr>
				<th colspan="3"><?php echo __('Page options'); ?></th>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_allow_html_title"><?php echo __('Allow HTML in Title'); ?></label></td>
				<td class="dform-field">
					<input type="checkbox" name="setting[allow_html_title]" <?php if (Setting::get('allow_html_title') == 'on') echo ' checked="checked"'; ?> />
				</td>
				<td class="dform-help"><?php echo __('Determines whether or not HTML code is allowed in a page\'s title.'); ?></td>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_translit_slug"><?php echo __('Translit slug'); ?></label></td>
				<td class="dform-field">
					<input type="checkbox" name="setting[translit_slug]" <?php if (Setting::get('translit_slug') == 'on') echo ' checked="checked"'; ?> />
				</td>
				<td class="dform-help"><?php  ?></td>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_default_status_id_draft"><?php echo __('Default Status'); ?></label></td>
				<td class="dform-field">
					<input class="input-radio" id="setting_default_status_id_draft" name="setting[default_status_id]" size="10" type="radio" value="<?php echo FrontPage::STATUS_DRAFT; ?>"<?php if (Setting::get('default_status_id') == FrontPage::STATUS_DRAFT) echo ' checked="checked"'; ?> /><label for="setting_default_status_id_draft"> <?php echo __('Draft'); ?> </label> &nbsp; 
					<input class="ibput-radio" id="setting_default_status_id_published" name="setting[default_status_id]" size="10" type="radio" value="<?php echo FrontPage::STATUS_PUBLISHED; ?>"<?php if (Setting::get('default_status_id') == FrontPage::STATUS_PUBLISHED) echo ' checked="checked"'; ?> /><label for="setting_default_status_id_published"> <?php echo __('Published'); ?> </label>
				</td>
				<td class="dform-help">&nbsp;</td>
			</tr>
			<tr>
				<td class="dform-label"><label for="setting_default_filter_id"><?php echo __('Default Filter'); ?></label></td>
				<td class="dform-field">
					<select class="input-select" id="setting_default_filter_id" name="setting[default_filter_id]">
						<?php $current_default_filter_id = Setting::get('default_filter_id'); ?>
						<option value="" <?php if( $current_default_filter_id == '' ) echo ('selected="selected"'); ?> >&ndash; <?php echo __('none'); ?> &ndash;</option>
						<?php foreach( $filters as $filter_id ): ?>
						<?php if( isset($loaded_filters[$filter_id]) ): ?>
						<option value="<?php echo $filter_id; ?>" <?php if( $filter_id == $current_default_filter_id ) echo ('selected="selected"'); ?> ><?php echo Inflector::humanize($filter_id); ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</td>
				<td class="dform-help"><?php echo __('Only for filter in pages, NOT in snippets'); ?></td>
			</tr>
		</table>
	</div>
	
	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save Changes'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<?php echo __('or'); ?> <a href="<?php echo get_url(); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>