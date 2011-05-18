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
<div class="dtable pages">
	<h3 class="dtable-def">
	    <span class="page-name"><?php echo __('Page'); ?> (<a href="javascript:void(0);" id="page_reorder"><?php echo __('reorder'); ?></a> <?php echo __('or'); ?> <a href="javascript:void(0);" id="page_copy"><?php echo __('copy'); ?></a>)</span>
		<span class="page-published"><?php echo __('Published'); ?></span>
	    <span class="page-status"><?php echo __('Status'); ?></span>
		<?php /* <span class="page-view"><?php echo __('View'); ?></span> */ ?>
	    <span class="page-modify"><?php echo __('Modify'); ?></span>
	</h3>
	
	<div class="pages-items">
		<ul id="pages_root">
			<li id="page-0">
				<div class="page-item">
					<span class="page-name">
						<img class="page-icon" src="images/page.png" title="/" alt="" />
						<?php if( $root->is_protected && !AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('developer') ): ?>
						 <span class="page-title"><?php echo $root->title; ?></span>
						<?php else: ?>
						<a href="<?php echo get_url('page/edit/1'); ?>" title="/"><span class="page-title"><?php echo $root->title; ?></span></a>
						<?php endif; ?>
					</span>
					
					<span class="page-eclipse"><!--x--></span>
					<span class="page-published">&nbsp;</span>
					
					<span class="page-status page-status-published"><?php echo __('Published'); ?></span>
					<span class="page-view"><a href="<?php echo URL_PUBLIC; ?>" target="_blank"><img src="images/icon-newwin.gif" class="page-smallicon" title="<?php echo __('View') .' ('. __('In a new window') .')'; ?>" alt="" /></a>&nbsp;</span>
					<span class="page-modify">
						<a class="page-add" href="<?php echo get_url('page/select_type/1'); ?>"><img class="page-smallicon page-add" src="images/plus.png" title="<?php echo __('Add child'); ?>" alt="" /></a>&nbsp; 
						<img class="page-smallicon page-remove-disabled" src="images/icon-remove-disabled.png" title="<?php echo __('Remove'); ?>" alt="" />
					</span>
				</div>
		    </li>
		</ul>

		<?php echo $content_children; ?>
	</div>
	
</div>