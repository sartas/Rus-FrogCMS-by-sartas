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
	/*
	  public static function deleteParts( $layout )
	  {
	  foreach ( self::getPartsClass( $layout->parts ) as $className )
	  {
	  self::$__CONN__->exec( 'DELETE FROM ' . self::tableNameFromClassName( $className ) . ' WHERE layout_id=' . (int) $layout->id );
	  }
	  }
	 */

	public static function getParts( $page )
	{
		foreach ( LayoutPart::findAllByLayoutId( $page->layout_id ) as $layout_part )
		{
			$part_class = Inflector::camelize( 'part_' . $layout_part->type );

			$part = new $part_class();
			$part = $part::findOneByPartId( $layout_part->id );

			$part->type = $layout_part->type;
			$part->name = $layout_part->name;
			$part->title = $layout_part->title;

			$page_parts[] = $part;
		}
		return $page_parts;
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
