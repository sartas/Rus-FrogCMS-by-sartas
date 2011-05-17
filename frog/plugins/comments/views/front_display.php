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
<ul class="comments-list" id="comments_list">
<?php foreach( $comments as $comment ): ?>
	<li class="comment-item" id="comment_<?php echo $comment->id; ?>">
		<!--noindex--><noindex>
		<h5 class="comment-author">
			<span class="comment-author-gravatar"><a href="<?php echo $comment->gravatar(100); ?>" target="_blank" rel="nofollow"><img src="<?php echo $comment->gravatar(16); ?>" width="16" height="16" class="comment-author-gravatar-img" /></a></span>
			<span class="comment-author-name"><?php echo $comment->name(); ?></span>
		</h5>
		
		<div class="comment-body">
			<?php echo $comment->body; ?>
		</div>
		</noindex><!--/noindex-->
		
		<p class="comment-date"><small><?php echo $comment->date(); ?></small></p>
	</li>
<?php endforeach; ?>
</ul>