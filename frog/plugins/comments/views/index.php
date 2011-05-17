<?php if(!defined('DEBUG')) die;

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2010 Maslakov Alexandr <jmas.ukraine@gmail.com>
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
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package frog
 * @subpackage plugin.comments
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 1.2.0
 * @since Frog version 0.9.3
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, Bebliuc George & Martijn van der Kleijn, 2008
 */

?>
<table class="dtable comments" id="comments">
	<thead>
		<tr>
			<th class="comment-summary"><?php echo __('Comments'); ?></th>
			<th class="comment-date"><?php echo __('Date'); ?></th>
			<th class="comment-status"><?php echo __('Status'); ?></th>
			<th class="comment-page"><?php echo __('Page'); ?></th>
			<th class="comment-actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($comments as $comment): ?>
		<tr id="comment_<?php echo $comment->id; ?>" class="<?php if( $comment->is_approved == Comment::APPROVED ) echo('comment-approved'); else echo('comment-unapproved'); ?>" >
			<td class="comment-summary">
				<h4>
					<span class="comment-author-name"><?php echo __($comment->author_name); ?></span>
					<span class="comment-author-email"><?php echo (empty($comment->author_email) ? __('no email') : __($comment->author_email)); ?></span>
					<span class="comment-author-link"><?php echo (empty($comment->author_link) ? __('no link') : __($comment->author_link)); ?></span>
				</h4>
				<div class="comment-body">
					<?php echo __($comment->body); ?>
				</div>
			</td>
			<td class="comment-date"><?php echo( $comment->date() ); ?></td>
			<td class="comment-status"><?php echo( $comment->is_approved == Comment::APPROVED ? '<span class="comment-status-approved">'. __('Approved') .'</span>' : '<span class="comment-status-unapproved">'. __('Not approved') .'</span>' ); ?></td>
			<td class="comment-page"><a href="<?php echo get_url('page/edit/' . $comment->page_id); ?>"><?php echo $comment->page_title; ?></a></td>
			<td class="comment-actions">
				<a href="<?php echo get_url('plugin/comments/approve/' . $comment->id); ?>" title="<?php echo __('Approve'); ?>"><img src="images/icon-accept.png" /></a>
				<a href="<?php echo get_url('plugin/comments/remove/' . $comment->id); ?>" title="<?php echo __('Delete'); ?>"><img src="images/icon-remove.png" /></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>