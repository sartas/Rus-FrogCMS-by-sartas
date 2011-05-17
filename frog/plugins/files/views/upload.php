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
<h1><?php echo __('Upload files to: :dir', array(':dir' => $dir)); ?></h1>

<form id="files_upload" action="<?php echo get_url('plugin/files/upload' . $dir); ?>" method="post" class="dform files-upload" enctype="multipart/form-data">
	<div class="dform-area">
	
		<div class="files-uploader">
			
			<p id="files_swf_container" class="files-container"><input id="file_upload" name="file_upload" type="file" /></p>
			
			<div id="files_simple_container" class="files-container">
				<p><input id="file_simple_add" class="input-button" type="button" value="<?php echo __('Add new field'); ?>" /></p>
				<p class="files-item"><input name="file_upload[]" type="file" /></p>
			</div>
			
			<p id="files_switcher"><a id="files_switcher_simple" href="javascript:void(0);"><?php echo __('Switch uploader type'); ?></a></p>
			
		</div>
	
	</div>
	
	<p class="dform-buttons">
		<input id="files_upload_button" class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __('Upload files'); ?>" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/files'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>