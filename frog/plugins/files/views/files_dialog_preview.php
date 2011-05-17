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
<?php /*
<?php foreach( $dir->getDirs() as $dir ): ?>
<li><a class="files-d-opened-dir" href="javascript:void(0);" rel="<?php echo $dir->getPathShort(); ?>" title="<?php echo $dir->getName(); ?>"><em class="files-d-icon file-i-folder"><!--x--></em> <span><?php echo $dir->getName(); ?></span></a></li>
<?php endforeach; ?>
*/ ?>
<?php foreach( $dir->getFiles() as $file ): ?>
<li><a class="files-d-opened-file" href="javascript:void(0);" rel="/<?php echo $file->getPathShort(); ?>" title="<?php echo $file->getName(); ?>"><?php if(Plugin::isEnabled('image_resizer') && in_array($file->getExt(), array('jpg', 'jpeg', 'gif', 'png'))): ?><img src="<?php echo URL_PUBLIC . $file->getDirPath(); ?>100x60-<?php echo $file->getName(); ?>" alt="" /><?php else: ?><em class="files-d-icon file-i-<?php echo $file->getExt(); ?>"><!--x--></em><?php endif; ?> <span><?php echo $file->getName(); ?></span></a></li>
<?php endforeach; ?>