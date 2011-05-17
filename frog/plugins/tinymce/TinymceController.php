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
 * @subpackage tinymce
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */


class TinymceController extends PluginController
{
	public function links_js()
	{
		$root = Record::findByIdFrom('Page', 1);
        $childs_content = $this->_getChildsContent( 1, 0 );
		
		echo('var tinyMCELinkList = new Array(["'. $root->title .'", "'. URL_PUBLIC .'"]'. $childs_content .');');
	}
	
	private function _getChildsContent( $parent_id, $level )
	{
		$content = '';
		
		$childrens = Page::childrenOf($parent_id);
        
        foreach( $childrens as $index => $child )
        {
			$content .= ', ["'. str_repeat('—', $level+1) .' '. $child->title .'", "'. URL_PUBLIC . (USE_MOD_REWRITE === false ? '?/' : '') . ($uri = $child->getUri()) . (strstr($uri, '.') === false ? URL_SUFFIX : '') .'"]';
            $content .= $this->_getChildsContent( $child->id, $level+1 );
        }
        
        return $content;
	}
}

?>