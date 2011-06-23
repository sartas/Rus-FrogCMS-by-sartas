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
<ul <?php if($level == 1) echo('id="site_map"'); ?> class="page-level-<?php echo $level; ?>" >
	<?php foreach($childrens as $child): ?> 
    <li id="page_<?php echo $child->id; ?>" class="page-node <?php if( !$child->has_children ) echo('page-no-children'); else echo( $child->is_expanded ? 'page-children-loaded' : '' ); ?>">
		<div class="page-item">
			<span class="page-name">
				<?php if( $child->has_children ): ?>
				<a href="javascript:void(0);" class="page-expander <?php if($child->is_expanded) echo('page-expander-collapse'); ?>"><!--x--></a>
				<?php endif; ?>
				
				<img class="page-icon" src="images/page.png" title="<?php echo $child->slug; ?>" alt="" />
				<?php if( !AuthUser::hasPermission('administrator') && ! AuthUser::hasPermission('developer') && $child->is_protected ): ?>
				<span class="page-title page-protected"><?php echo $child->title; ?></span>
				<?php else: ?>
				<a href="<?php echo get_url('page/edit/'.$child->id); ?>" title="<?php echo $child->title; ?>"><span class="page-title"><?php echo $child->title; ?></span></a>
				<?php endif; ?>
				
				<img class="page-handle-reorder" src="images/drag_to_sort.gif" title="<?php echo __('Drag and Drop'); ?>" alt="" />
				<img class="page-handle-copy" src="images/drag_to_copy.gif" title="<?php echo __('Drag to Copy'); ?>" alt="" />
				
				<?php if( !empty($child->behavior_id) ): ?> <small class="page-info"><?php echo Inflector::humanize($child->behavior_id); ?></small><?php endif; ?> 
				<img class="page-busy" id="busy_<?php echo $child->id; ?>" src="images/spinner.gif" title="" alt="" />
			</span>
			
			<span class="page-eclipse"><!--x--></span>
			<span class="page-published"><?php echo date('d&#45;m&#45;Y', strtotime($child->published_on)); ?></span>

			<?php switch ($child->status_id):
				  case Page::STATUS_DRAFT:      echo('<span class="page-status page-status-draft">'.__('Draft').'</span>'); break;
				  case Page::STATUS_REVIEWED: 	echo('<span class="page-status page-status-reviewed">'.__('Reviewed').'</span>'); break;
				  case Page::STATUS_PUBLISHED:
					if( strtotime($child->published_on) > time() )
						echo('<span class="page-status page-status-wait">'.__('Wait').'</span>');
					else
						echo('<span class="page-status page-status-published">'.__('Published').'</span>');
					break;
				  case Page::STATUS_HIDDEN: 	echo('<span class="page-status page-status-hidden">'.__('Hidden').'</span>'); break;
			endswitch; ?>
			
			<span class="page-view"><a href="<?php echo(URL_PUBLIC . (USE_MOD_REWRITE === false ? '?/' : '') . ($uri = $child->getUri()) . (strstr($uri, '.') === false ? URL_SUFFIX : '')); ?>" target="_blank"><img src="images/icon-newwin.gif" class="page-smallicon" title="<?php echo __('View') .' ('. __('In a new window') .')'; ?>" alt="" /></a>&nbsp;</span>
			
			<span class="page-modify">
				<a class="page-add" href="#"><img class="page-smallicon" src="images/plus.png" title="<?php echo __('Add child'); ?>" alt="" /></a>&nbsp; 
				<?php if( !$child->is_protected || AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer') ): ?>
				<a class="page-remove" href="#" rel="<?php echo __('Are you sure you wish to delete'); ?> <?php echo $child->title; ?>?"><img class="page-smallicon" src="images/icon-remove.png" title="<?php echo __('Remove'); ?>" alt="" /></a>
				<?php endif; ?>
			</span>
		</div>
		
		<?php if( $child->is_expanded ) echo($child->children_rows); ?>
	</li>
	<?php endforeach; ?>
</ul>