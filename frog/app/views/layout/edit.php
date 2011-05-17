<?php
if ( !defined( 'DEBUG' ) )
	die;

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
<h1><?php echo __( ucfirst( $action ) . ' layout' ); ?></h1>

<form id="layout_edit_form" action="<?php echo $action == 'edit' ? get_url( 'layout/edit/' . $layout->id ) : get_url( 'layout/add' ); ?>" method="post" class="dform layout-edit">
	<div class="dform-area">
		<table class="dform-table">
			<tr>
				<td class="dform-label"><label for="layout_name"><?php echo __( 'Name' ); ?></label></td>
				<td class="dform-field"><input class="input-text" id="layout_name" maxlength="100" name="layout[name]" size="100" type="text" value="<?php echo $layout->name; ?>" /></td>
			</tr>
			<tr>
				<td class="dform-label"><label for="layout_content_type"><?php echo __( 'Content-Type' ); ?></label></td>
				<td class="dform-field"><input class="input-text" id="layout_content_type" maxlength="40" name="layout[content_type]" size="40" type="text" value="<?php echo $layout->content_type; ?>" /></td>
			</tr>
		</table>

		<div class="content-area layout-content">
			<label for="layout_content"><?php echo __( 'Body' ); ?></label>
			<textarea class="input-textarea input-textarea-code" cols="40" id="layout_content" name="layout[content]" rows="20" style="width: 100%"><?php echo htmlentities( $layout->content, ENT_COMPAT, 'UTF-8' ); ?></textarea>
			<div style="width:500px">
				<h3>Parts:</h3>
				<table class="dform-table" id="layout_parts">
					<?php foreach ( $parts as $part ) : ?>
						<tr id="part_<?= $part->id; ?>">
							<td><?= $part->title; ?></td>
							<td><?= $part->name; ?></td>
							<td><?= $part->type; ?></td>
							<td><a href="#" onclick="frogLayoutEdit.editPartClick(<?= $part->id; ?>);return false;">Edit</a></td>
							<td><a href="#" onclick="frogLayoutEdit.deletePartClick(<?= $part->id; ?>, '<?= $part->title; ?>');return false;">Delete</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<a href="#" onclick="frogLayoutEdit.addPartClick(<?= $layout->id; ?>);return false;">Add</a>

			</div>
		</div>



		<?php if ( isset( $layout->updated_on ) ): ?>
			<p class="layout-updated"><small><?php echo __( 'Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url( 'user/edit/' . $layout->updated_by_id ), ':name' => $layout->updated_by_name, ':date' => date( 'D, j M Y', strtotime( $layout->updated_on ) )) ); ?></small></p>
		<?php endif; ?>
	</div>

	<p class="dform-buttons">
		<input class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __( 'Save and Close' ); ?>" title="<?php echo __( 'Or press' ); ?> Alt+S" />
		<input class="input-button" name="continue" type="submit" accesskey="e" value="<?php echo __( 'Save and Continue Editing' ); ?>" title="<?php echo __( 'Or press' ); ?> Alt+E" />
		<?php echo __( 'or' ); ?> <a href="<?php echo get_url( 'layout' ); ?>"><?php echo __( 'Cancel' ); ?></a>
	</p>
</form>