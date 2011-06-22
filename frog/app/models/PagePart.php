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

	public function findOneByPartIdPageId( $part_id, $page_id )
	{
		return self::findOneFrom( get_class( $this ), 'part_id=' . (int) $part_id . ' AND page_id=' . (int) $page_id );
	}

	public function edit( $vars=array() )
	{
		$class_name = get_class( $this );
		return new View( '../../plugins/' . constant( $class_name . '::TABLE_NAME' ) . '/views/part_edit', $vars );
	}

	public static function deleteParts( $page )
	{
		$parts = FrontPage::getParts( $page );
		if ( !empty( $parts ) )
		{
			foreach ( $parts as $part )
			{
				$part->delete();
			}
		}
	}

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
