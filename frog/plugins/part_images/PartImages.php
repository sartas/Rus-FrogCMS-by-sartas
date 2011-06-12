<?php

if ( !defined( 'DEBUG' ) )
	die;

/**
 * @package frog
 * @subpackage models
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * class PageText
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since Frog version 0.1
 */
class PartImages extends PagePart {
	const TABLE_NAME = 'part_images';

	public $part_id;
	public $page_id;
	//public $images;
	public $file_name;
	public $alternate;


	public function content()
	{
		return $this->images;
	}

	public function url()
	{
		return URL_PUBLIC . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . $this->file_name;
	}

	public function thumb( $width = null, $height = null )
	{
		if ( Plugin::isEnabled( 'image_resizer' ) )
		{
			return URL_PUBLIC . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . ( $width ? $width : 0 ) . 'x' . ( $height ? $height : 0 ) . '-' . $this->file_name;
		}
		else
			return $this->url();
	}

	public function findOneByPartIdPageId( $part_id, $page_id )
	{
		$part = new PartImages();
		$part->part_id = $part_id;
		$part->page_id = $page_id;

		$part->images =  Record::findAllFrom( 'PartImages', 'part_id=' . (int) $part_id . ' AND page_id=' . (int) $page_id );

		return $part;
	}
	
	public function beforeDelete()
	{
		use_helper( 'Dir' );

		$file_path = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . $this->file_name;
		$image_file = new DirFileImage( $file_path );
		$image_file->remove( true );

		return true;
	}
}

// end PageImages class
