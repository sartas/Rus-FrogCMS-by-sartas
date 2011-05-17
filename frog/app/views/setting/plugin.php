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
<table class="dtable plugins" id="plugins">
	<thead>
		<tr>
			<th class="plugin-name"><?php echo __('Plugin'); ?></th>
			<th class="plugin-settings"><?php echo __('Settings'); ?></th>
			<th class="plugin-website"><?php echo __('Website'); ?></th>
			<th class="plugin-version"><?php echo __('Version'); ?></th>
			<th class="plugin-latest"><?php echo __('Latest'); ?></th>
			<th class="plugin-enabled"><?php echo __('Enabled'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($plugins as $plugin): ?>
		<?php $disabled = (isset($plugin->require_frog_version) && $plugin->require_frog_version > FROG_VERSION); ?>
		<tr id="plugin_<?php echo $plugin->id; ?>" class="<?php if( $disabled ) echo('plugin-disabled '); if( isset($loaded_plugins[$plugin->id]) ) echo('plugin-active'); ?> " >
			<td class="plugin-name">
				<h4>
					<?php
					if (isset($loaded_plugins[$plugin->id]) && Plugin::hasDocumentationPage($plugin->id) )
						echo '<a href="'.get_url('plugin/'.$plugin->id.'/documentation').'">'. __($plugin->title) .'</a>';
					else
						echo $plugin->title;
					?>
					<small class="plugin-author"><?php if( isset($plugin->author) ) echo ' '. __('by') .' '.$plugin->author; ?></small>
				</h4>
				<p class="plugin-description"><?php echo __($plugin->description); ?> <?php if( $disabled ) echo('<span class="plugin-notes">'.__('This plugin cannot be enabled! It requires Frog version :v.', array(':v' => $plugin->require_frog_version)).'</span>'); ?></p>
			</td>
			<td class="plugin-settings">
				<?php
					if( isset($loaded_plugins[$plugin->id]) && Plugin::hasSettingsPage($plugin->id) )
						echo '<a href="'. get_url('plugin/'.$plugin->id.'/settings') .'">'. __('Settings') .'</a>';
					else
						echo __('n/a');
				?>
			</td>
			<td class="plugin-website"><a href="<?php echo $plugin->website; ?>" target="_blank"><?php echo __('Website') ?></a></td>
			<td class="plugin-version"><?php echo $plugin->version; ?></td>
			<td class="plugin-latest"><?php echo (($latest = Plugin::checkLatest($plugin)) == 'unknown' ? __('Unknown') : $latest); ?></td>
			<td class="plugin-enabled"><span><input type="checkbox" name="plugins[<?php echo $plugin->id; ?>]" value="<?php echo $plugin->id; ?>" <?php if( isset($loaded_plugins[$plugin->id]) ) echo('checked="checked"'); if( $disabled ) echo('disabled="disabled"'); ?> class="plugin-enabled-checkbox" /></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>