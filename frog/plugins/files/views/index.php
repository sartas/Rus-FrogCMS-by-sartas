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
<div class="dtable files">
	<h3 class="dtable-def">
	    <span class="file-name"><?php echo __('Directory or file'); ?><?php /* (<a href="javascript:void(0);" id="file_copy"><?php echo __('copy'); ?></a>) */ ?></span>
	    <span class="file-size"><?php echo __('Size'); ?></span>
		<span class="file-perm"><?php echo __('Permissions'); ?></span>
		<span class="file-view"><?php echo __('View'); ?></span>
	    <span class="file-modify"><?php echo __('Modify'); ?></span>
	</h3>
	
	<div class="files-items">
		<ul id="files_root">
			<li id="file-0">
				<div class="file-item">
					<span class="file-name">
						<span class="file-icon file-folder"><!--x--></span>
						<?php if( 1 && !AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('developer') ): ?>
						 <span class="file-title"><?php echo PUBLIC_FILES; ?></span>
						<?php else: ?>
						<span class="file-title"><?php echo PUBLIC_FILES; ?></span>
						<?php endif; ?>
					</span>
					<span class="file-size"><span class="file-empty">&ndash;</span></span>
					<span class="file-perm"><span class="file-empty">&ndash;</span></span>
					<span class="file-view"><span class="file-empty">&ndash;</span></span>
					<span class="file-modify">
						<a class="file-add" href="<?php echo get_url('plugin/files/upload/public/'); ?>"><img class="file-smallicon file-add" src="../frog/plugins/files/images/upload.png" title="<?php echo __('Upload files'); ?>" alt="" /></a>
						&nbsp;
						<img class="file-smallicon file-remove-disabled" src="images/icon-remove-disabled.png" title="<?php echo __('Remove'); ?>" alt="" />
					</span>
				</div>
		    </li>
		</ul>

		<?php echo $content_children; ?>
	</div>
</div>