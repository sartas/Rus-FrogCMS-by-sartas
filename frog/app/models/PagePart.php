<?php

if ( !defined( 'DEBUG' ) )
	die;

/**
 * class PagePart
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since Frog version 0.1
 */
class PagePart extends Record {

	public static $types = array();

	public static function addType( $type )
	{
		if ( !in_array( $type, self::$types ) )
		{
			self::$types[] = $type;
		}
	}

	public static function getTypes()
	{
		return self::$types;
	}

}

// end PagePart class
