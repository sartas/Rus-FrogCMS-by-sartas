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
 * @subpackage files
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */

?>
<h1><?php echo __(ucfirst($action).' Data') . ' ' . $data->name; ?></h1>

<form id="special-data-edit" action="<?php echo get_url() , ($action=='edit' ? 'plugin/special_data/edit/'. $data->id : 'plugin/special_data/add'); ?>" method="post" class="dform">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<td class="dform-label"><label for="special-data-name"><?php echo __('Name'); ?></label></td>
				<td class="dform-field"><input class="input-text" id="special-data-name" maxlength="100" name="data[name]" size="100" type="text" value="<?php echo $data->name; ?>" /></td>
			</tr>
			<tr>
				<td class="dform-label"><label for="special-data-identifier"><?php echo __('Identifier'); ?></label></td>
				<td class="dform-field"><input class="input-text" id="special-data-identifier" maxlength="100" name="data[identifier]" size="100" type="text" value="<?php echo $data->identifier; ?>" <?php if(!AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('developer')) echo('disabled'); ?> /></td>
			</tr>
			<?php if( $action == 'add' ): ?>
			<tr>
				<td class="dform-label"><label for="special-data-value"><?php echo __('Type'); ?></label></td>
				<td class="dform-field">
					<select id="special-data-type" class="input-select" name="data[type]">
						<option value="">&mdash;</option>
						<option value="wysiwyg" <?php if($data->type == 'wysiwyg') echo('selected'); ?> ><?php echo __('TinyMCE'); ?></option>
						<option value="text" <?php if($data->type == 'text') echo('selected'); ?> ><?php echo __('Text'); ?></option>
						<option value="file" <?php if($data->type == 'file') echo('selected'); ?> ><?php echo __('File'); ?></option>
					</select>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		
		<?php if( $action == 'edit' ): ?>
	    <div class="content-area file-e-content">
			<label for="special-data-value"><?php echo __('Value'); ?></label>
			<div id="special-data-value">
				<textarea id="special-data-value-<?php echo $data->type; ?>" class="input-textarea" cols="40" name="data[value]" rows="20" style="width: 100%"><?php echo htmlentities($data->value, ENT_COMPAT, 'UTF-8'); ?></textarea>
			</div>
		</div>
		<?php endif; ?>
	
		<?php /* if( isset($file->updated_on) ): ?>
		<p class="file-e-updated"><small><?php echo __('Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url('user/edit/' . $file->updated_by_id), ':name' => $file->updated_by_name, ':date' => date('D, j M Y', strtotime($file->updated_on)))); ?></small></p>
		<?php endif; */ ?>
	</div>
	
	<p class="dform-buttons">
		<?php if( $action == 'edit' ): ?>
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save and Close'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<?php endif; ?>
		<input class="input-button" name="continue" type="submit" accesskey="e" value="<?php echo __('Save and Continue Editing'); ?>" title="<?php echo __('Or press'); ?> Alt+E" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/special_data'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>