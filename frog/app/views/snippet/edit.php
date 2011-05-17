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
<h1><?php echo __(ucfirst($action).' snippet'); ?></h1>

<form id="snippet_edit_form" action="<?php echo $action=='edit' ? get_url('snippet/edit/'.$snippet->id): get_url('snippet/add'); ; ?>" method="post" class="dform snippet-edit">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<td class="dform-label"><label for="snippet_name"><?php echo __('Name'); ?></label></td>
				<td class="dform-field"><input class="input-text" id="snippet_name" maxlength="100" name="snippet[name]" size="255" type="text" value="<?php echo $snippet->name; ?>" /></td>
			</tr>
		</table>
	
		<div class="content-area snippet-content">
			<p class="snippet-filter">
				<label for="snippet_filter_id"><?php echo __('Filter'); ?></label>
				<select id="snippet_filter_id" class="input-select" name="snippet[filter_id]">
					<option value=""<?php if($snippet->filter_id == '') echo ' selected="selected"'; ?>>&ndash; <?php echo __('none'); ?> &ndash;</option>
					<?php foreach ($filters as $filter): ?>
					<option value="<?php echo $filter; ?>"<?php if($snippet->filter_id == $filter) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<textarea class="input-textarea input-textarea-code" cols="40" id="snippet_content" name="snippet[content]" rows="20" style="width: 100%"><?php echo htmlentities($snippet->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
		</div>

		<?php if (isset($snippet->updated_on)): ?>
		<p class="snippet-updated"><small><?php echo __('Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url('user/edit/' . $snippet->updated_by_id), ':name' => $snippet->updated_by_name, ':date' => date('D, j M Y', strtotime($snippet->updated_on)))); ?></small></p>
		<?php endif; ?>
	</div>
	
	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save and Close'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<input class="input-button" name="continue" type="submit" accesskey="e" value="<?php echo __('Save and Continue Editing'); ?>" title="<?php echo __('Or press'); ?> Alt+E" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('snippet'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>