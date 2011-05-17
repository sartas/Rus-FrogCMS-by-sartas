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
<?php /* <h1><?php echo __('Layouts'); ?></h1> */ ?>

<div class="dtable layouts" id="layouts">
	<h3 class="dtable-def">
		<span class="layout-name"><?php echo __('Layout'); ?></span>
		<span class="layout-modify"><?php echo __('Modify'); ?></span>
	</h3>
	<div class="dtable-content">
		<?php foreach($layouts as $layout): ?>
		<p id="snippet_<?php echo $layout->id; ?>" class="dtable-item layout-item">
			<span class="layout-name"><img src="images/layout.png" class="dtable-icon snippet-icon" alt="snippet" /> <a href="<?php echo get_url('layout/edit/'.$layout->id); ?>"><?php echo $layout->name; ?></a></span>
		    <span class="layout-modify"><a href="<?php echo get_url('layout/delete/'.$layout->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $layout->name; ?>?');" title="<?php echo __('Remove'); ?>"><img src="images/icon-remove.png" class="dtable-smallicon layout-removeicon" alt="" />&nbsp;</a></span>
		</p>
		<?php endforeach; ?>
	</div>
</div>

<?php /*
<div id="layouts-def" class="index-def">
  <div class="layout"><?php echo __('Layout'); ?> (<a href="#" onclick="$$('.handle').each(function(e) { e.style.display = e.style.display != 'inline' ? 'inline': 'none'; }); return false;"><?php echo __('reorder'); ?></a>)</div>
</div>

<ul id="layouts" class="index">
<?php foreach($layouts as $layout) { ?>
  <li id="layout_<?php echo $layout->id; ?>" class="layout node <?php echo odd_even(); ?>">
    <img align="middle" alt="layout-icon" src="images/layout.png" title="" />
    <a href="<?php echo get_url('layout/edit/'.$layout->id); ?>"><?php echo $layout->name; ?></a>
    <img class="handle" src="images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" />
    <div class="remove"><a href="<?php echo get_url('layout/delete/'.$layout->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $layout->name; ?>?');"><img alt="<?php echo __('Remove Layout'); ?>" src="images/icon-remove.gif" /></a></div>
  </li>
<?php } ?>
</ul>

<script type="text/javascript" language="javascript" charset="utf-8">
Sortable.create('layouts', {
    constraint: 'vertical',
    scroll: window,
    handle: 'handle',
    onUpdate: function() {
        new Ajax.Request('index.php?/layout/reorder', {method: 'post', parameters: {data: Sortable.serialize('layouts')}});
    }
});
</script>
*/