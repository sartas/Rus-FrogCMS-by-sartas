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
<div class="dtable snippets" id="snippets">
	<h3 class="dtable-def">
		<span class="snippet-name"><?php echo __('Snippet'); ?></span>
		<span class="snippet-modify"><?php echo __('Modify'); ?></span>
	</h3>
	<div class="dtable-content">
		<?php foreach($snippets as $snippet): ?>
		<p id="snippet_<?php echo $snippet->id; ?>" class="dtable-item snippet-item">
			<span class="snippet-name"><img src="images/snippet.png" class="dtable-icon snippet-icon" alt="snippet" /> <a href="<?php echo get_url('snippet/edit/'.$snippet->id); ?>"><?php echo $snippet->name; ?></a></span>
		    <span class="snippet-modify"><a href="<?php echo get_url('snippet/delete/'.$snippet->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $snippet->name; ?>?');" title="<?php echo __('Remove'); ?>"><img src="images/icon-remove.png" class="dtable-smallicon snippet-removeicon" alt="" />&nbsp;</a></span>
		</p>
		<?php endforeach; ?>
	</div>
</div>

<?php /*
<div id="site-map-def" class="index-def">
  <div class="snippet"><?php echo __('Snippet'); ?> (<a href="#" onclick="$$('.handle').each(function(e) { e.style.display = e.style.display != 'inline' ? 'inline': 'none'; }); return false;"><?php echo __('reorder'); ?></a>)</div><div class="modify"><?php echo __('Modify'); ?></div>
</div>

<ul id="snippets" class="index">
<?php foreach($snippets as $snippet): ?>
  <li id="snippet_<?php echo $snippet->id; ?>" class="snippet node <?php echo odd_even(); ?>">
    <img align="middle" alt="snippet-icon" src="images/snippet.png" />
    <a href="<?php echo get_url('snippet/edit/'.$snippet->id); ?>"><?php echo $snippet->name; ?></a>
    <img class="handle" src="images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" />
    <div class="remove"><a class="remove" href="<?php echo get_url('snippet/delete/'.$snippet->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $snippet->name; ?>?');"><img src="images/icon-remove.gif" alt="remove icon" /></a></div>
  </li>
<?php endforeach; ?>
</ul>

<script type="text/javascript" language="javascript" charset="utf-8">
Sortable.create('snippets', {
    constraint: 'vertical',
    scroll: window,
    handle: 'handle',
    onUpdate: function() {
        new Ajax.Request('index.php?/snippet/reorder', {method: 'post', parameters: {data: Sortable.serialize('snippets')}});
    }
});
</script>
*/ ?>