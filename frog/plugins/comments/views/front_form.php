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
<a name="comments_form"></a>

<?php if( $error ): ?>
<p id="comments_error"><?php echo $error; ?></p>
<?php endif; ?>
<?php if( $success ): ?>
<p id="comments_success"><?php echo $success; ?></p>
<?php endif; ?>

<form action="<?php echo $page->url(); ?>#comments_form" method="post" id="comments_form"> 
	<p>
	    <label for="comment_form_name"><?php echo __('Name') . ' ('. __('required') .')'; ?>:</label>
		<span><input id="comment_form_name" class="comment-form-name" type="text" name="comment[author_name]" value="<?php echo $form->author_name; ?>" size="22" /></span>
	</p>
	<p>
	    <label for="comment_form_email"><?php echo __('E-mail') . ' ('. __('required') .')'; ?>:</label>
		<span><input id="comment_form_email" class="comment-form-email" type="text" name="comment[author_email]" value="<?php echo $form->author_email; ?>" size="22" /></span>
	</p>
	<p>
	    <label for="comment_form_link"><?php echo __('Website'); ?>:</label>
		<span><input id="comment_form_link" class="comment-form-link" type="text" name="comment[author_link]" value="<?php echo $form->author_link; ?>" size="22" /></span>
	</p>
	<p>
		<label for="comment_form_body"><?php echo __('Comment'); ?>:</label>
	    <span><textarea id="comment_form_body" class="comment-form-body" name="comment[body]" cols="100%" rows="10"><?php echo htmlentities(str_replace('<br />', "\n", $form->body), ENT_COMPAT, 'UTF-8'); ?></textarea></span>
		<div class="comment-allowed-tags"><?php echo __('Allowed tags'); ?>: &lt;a&gt;, &lt;abbr&gt;, &lt;acronym&gt;, &lt;b&gt;, &lt;blockquote&gt;, &lt;br /&gt;, &lt;code&gt;, &lt;em&gt;, &lt;i&gt;, &lt;p&gt;, &lt;strike&gt;, &lt;strong&gt;</div>
	</p>
<?php if( Plugin::isEnabled('captcha') && $use_captcha === true ): ?>
	<p>
		<label for="comment_form_captcha"><img src="<?php echo URL_PUBLIC; ?>captcha.jpg" alt="Captcha code" id="captcha_image" title="<?php echo __('Captcha code'); ?>" title="<?php echo __('Type text that present on this image.'); ?>" /></label>
		<span><input id="comment_form_captcha" class="comment-form-captcha" type="text" name="captcha" value="" /></span>
	</p>
<?php endif; ?>
	<p>
	    <input id="comment_form_submit" class="comment-form-submit" type="submit" name="commit-comment" value="<?php echo __('Submit comment'); ?>" />
	</p>
</form>