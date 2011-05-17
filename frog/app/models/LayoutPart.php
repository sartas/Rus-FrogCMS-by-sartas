<?php

if ( !defined( 'DEBUG' ) )
	die;

/**
 * @package frog
 * @subpackage controllers
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * Class PagePart
 * 
 * @package frog
 * @subpackage controllers
 *
 * @since 0.1
 */
class LayoutPart extends Record {
	const TABLE_NAME = 'layout_part';

	public $layout_id = '';
	public $type = '';
	public $name = '';
	public $title = '';

	public static function findAllByLayoutId( $layout_id )
	{
		return self::findAllFrom( 'LayoutPart', 'layout_id=' . (int) $layout_id . ' ORDER BY id' );
	}


}

// end class
