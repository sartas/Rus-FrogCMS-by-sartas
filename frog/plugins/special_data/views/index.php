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
<table id="special-data-table" class="dtable">
	<thead>
		<tr>
			<th class="name"><?php echo __('Name'); ?>/<?php echo __('Identifier'); ?></th>
			<th class="value"><?php echo __('Value'); ?></th>
			<th class="modify"><?php echo __('Modify'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($datas as $data): ?>
		<tr id="data_<?php echo $data->id; ?>">
			<td class="name"><?php echo( $data->name ); ?> <em><?php echo( $data->identifier ); ?></em></td>
			<td class="value">
			
				<?php if( $data->type == 'file' && preg_match('/\.(jpg|gif|png)$/i', $data->value) ): ?>
					<img src="<?php echo( $data->value ); ?>" alt="<?php echo( $data->value ); ?>" title="<?php echo( $data->value ); ?>" />
				<?php else: ?>
					<?php echo( $data->value ); ?>
				<?php endif; ?>
			
			</td>
			<td class="modify">
				<a href="<?php echo get_url('plugin/special_data/edit/' . $data->id); ?>" title="<?php echo __('Edit'); ?>"><img src="images/icon-edit.png" alt="<?php echo __('Edit'); ?>"  title="<?php echo __('Edit'); ?>" /></a>
				<?php if(AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer')): ?><a href="<?php echo get_url('plugin/special_data/remove/' . $data->id); ?>" title="<?php echo __('Delete'); ?>"><img src="images/icon-remove.png" alt="<?php echo __('Delete'); ?>"  title="<?php echo __('Delete'); ?>" /></a><?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>