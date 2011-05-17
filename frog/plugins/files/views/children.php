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
<ul <?php if($level == 1) echo('id="files_tree"'); ?> class="file-level-<?php echo $level; ?>" >
	<?php foreach( $folder->getDirs() as $dir ): ?>
	    <li id="file_<?php echo $dir->getId(); ?>" rel="<?php echo $dir->getPathShort() ; ?>" class="file-node-folder <?php if(!$dir->hasChildrens()) echo('file-no-children'); ?>">
		<div class="file-item">
			<span class="file-name">
				<?php if( $dir->hasChildrens() ): ?>
				<a href="javascript:void(0);" class="file-expander <?php /* if($children->is_expanded) echo('file-expander-collapse'); */ ?>"><!--x--></a>
				<?php endif; ?>
				
				<span class="file-icon file-folder" title="<?php echo $dir->getName(); ?>"><!--x--></span>
				<span class="file-title"><?php echo $dir->getName(); ?></span>
				
				<img class="file-handle-copy" src="images/drag_to_copy.gif" title="<?php echo __('Drag to Copy'); ?>" alt="" />
				
				<img class="file-busy" id="busy_<?php echo $dir->getId(); ?>" src="images/spinner.gif" title="" alt="" />
			</span>

			<span class="file-size"><span class="file-empty">&ndash;</span></span>
			<span class="file-perm"><a class="file-perm-link" href="<?php echo get_url('plugin/files/perms_dialog/'. $dir->getPathShort()); ?>" title="<?php echo __('Change permissions'); ?>"><?php echo $dir->getPermsShort(); ?></a> <small><?php echo $dir->getPermsString(); ?></small></span>
			<span class="file-view"><span class="file-empty">&ndash;</span></span>
			
			<span class="file-modify">
				<a href="<?php echo get_url('plugin/files/upload/' . $dir->getPathShort()); ?>"><img class="file-smallicon" src="../frog/plugins/files/images/upload.png" title="<?php echo __('Upload files'); ?>" alt="" /></a>
				&nbsp;
				<?php if( AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer') ): ?>
				<a class="file-remove" href="<?php echo get_url('plugin/files/delete/'. $dir->getPathShort()); ?>"><img class="file-smallicon" src="images/icon-remove.png" title="<?php echo __('Remove'); ?>" alt="" /></a>
				<?php endif; ?>
			</span>
		</div>
		
		<?php /* if( $children->is_expanded ) echo($children->children_rows); */ ?>
	</li>
	<?php endforeach; ?>
	
	<?php if( $folder->hasFiles() ): ?>
	<?php foreach( $folder->getFiles() as $file ): ?>
    <li id="file_<?php echo $file->getId(); ?>" rel="<?php echo $file->getPathShort() ; ?>" class="file-node-file">
		<div class="file-item">
			<span class="file-name">
				<span class="file-icon file-i-<?php echo $file->getExt(); ?>" title="<?php echo $file->getName(); ?>"><!--x--></span>
				<a href="<?php echo get_url('plugin/files/edit/'. $file->getPathShort()); ?>" title="<?php echo $file->getName(); ?>"><span class="file-title"><?php echo $file->getName(); ?></span></a>
				
				<img class="file-handle-copy" src="images/drag_to_copy.gif" title="<?php echo __('Drag to Copy'); ?>" alt="" />
				
				<img class="file-busy" id="busy_<?php echo $file->getName(); ?>" src="images/spinner.gif" title="" alt="" />
			</span>

			<span class="file-size"><?php echo convert_size($file->getSize()); ?></span>
			<span class="file-perm"><a class="file-perm-link" href="<?php echo get_url('plugin/files/perms_dialog/'. $file->getPathShort()); ?>" title="<?php echo __('Change permissions'); ?>"><?php echo $file->getPermsShort(); ?></a> <small><?php echo $file->getPermsString(); ?></small></span>
			<span class="file-view"><a href="<?php echo URL_PUBLIC . $file->getPathShort(); ?>" target="_blank"><img src="images/icon-newwin.gif" class="file-smallicon" title="<?php echo __('View') .' ('. __('In a new window') .')'; ?>" alt="" /></a>&nbsp;</span>
			
			<span class="file-modify">
				<img class="file-smallicon" src="../frog/plugins/files/images/upload-disabled.png" alt="" />
				&nbsp;
				<?php if( AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer') ): ?>
				<a class="file-remove" href="<?php echo get_url('plugin/files/delete/'. $file->getPathShort()); ?>"><img class="file-smallicon" src="images/icon-remove.png" title="<?php echo __('Remove'); ?>" alt="" /></a>
				<?php endif; ?>
			</span>
		</div>
	</li>
	<?php endforeach; ?>
	<?php endif; ?>
</ul>