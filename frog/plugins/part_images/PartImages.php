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

	public function findOneByPartIdPageId( $part_id, $page_id )
	{
		$part = new PartImages();
		$part->part_id = $part_id;
		$part->page_id = $page_id;

		$part->images = Record::findAllFrom( 'FrontPartImages', 'part_id=' . (int) $part_id . ' AND page_id=' . (int) $page_id );

		return $part;
	}

	public function delete()
	{
		if ( !($this->part_id) || !($this->page_id) )
			return;

		Record::deleteWhere( 'PagePart', 'part_id=' . (int) $this->part_id . ' AND page_id=' . (int) $this->page_id );

		if ( !empty( $this->images ) )
		{
			use_helper( 'Dir' );

			foreach ( $this->images as $image )
			{
				$file_path = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery/' . $image->page_id . '/' . $image->file_name;
				if ( file_exists( $file_path ) )
				{
					$image_file = new DirFileImage( $file_path );
					$image_file->remove( true );
				}
			}
		}
		return true;
	}


//	public function afterDelete( $result )
//	{
//		if ( $result == true )
//		{
//			use_helper( 'Dir' );
//
//			$file_path = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . $this->file_name;
//			$image_file = new DirFileImage( $file_path );
//			$image_file->remove( true );
//		}
//		return true;
//	}
}

// end PageImages class