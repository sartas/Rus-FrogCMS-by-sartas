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
<h1><?php echo __(ucfirst($action).' file') . ' ' . $file->name; ?></h1>

<form id="file_edit_form" action="<?php echo get_url() .'?/'. ($action=='edit' ? 'plugin/files/edit'. $file->name : '?/plugin/files/add'); ?>" method="post" class="dform file-e-edit">
	<div class="dform-area">			
	    <div class="content-area file-e-content">
			<label for="file_content"><?php echo __('Body'); ?></label>
			<textarea class="input-textarea input-textarea-code" cols="40" id="file_content" name="file[content]" rows="20" style="width: 100%"><?php echo htmlentities($file->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
		</div>
	
		<?php if( isset($file->updated_on) ): ?>
		<p class="file-e-updated"><small><?php echo __('Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url('user/edit/' . $file->updated_by_id), ':name' => $file->updated_by_name, ':date' => date('D, j M Y', strtotime($file->updated_on)))); ?></small></p>
		<?php endif; ?>
	</div>
	
	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save and Close'); ?>" title="<?php echo __('Or press'); ?> Alt+S" />
		<input class="input-button" name="continue" type="submit" accesskey="e" value="<?php echo __('Save and Continue Editing'); ?>" title="<?php echo __('Or press'); ?> Alt+E" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/files'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>