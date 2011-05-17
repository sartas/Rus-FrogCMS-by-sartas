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
class PartText extends Record {
	const TABLE_NAME = 'part_text';


	public $page_id = '';
	public $filter_id = '';
	public $content = '';
	public $content_html = '';
	/*
	  public static function type()
	  {
	  return str_replace( 'part_', '', self::TABLE_NAME );
	  }
	 */

	public function edit( $vars=array() )
	{
		return new View( '../../plugins/' . self::TABLE_NAME . '/views/part_edit', $vars );
	}

	public function beforeSave()
	{
		/* 		$this->content = stripslashes( $this->content );

		  // apply filter to save is generated result in the database
		  if ( ! empty($this->filter_id))
		  {
		  $this->content_html = Filter::get($this->filter_id)->apply($this->content);

		  foreach(Observer::getObserverList('filter_content') as $callback)
		  $this->content_html = call_user_func($callback, $this->content_html);
		  }
		  else
		 */ $this->content_html = $this->content;

		return true;
	}

	public static function findByLayoutId( $id )
	{
		return self::findAllFrom( 'PartText', 'layout_id=' . (int) $id . ' ORDER BY id' );
	}

	public static function findByPageId( $id )
	{
		return self::findAllFrom( 'PartText', 'page_id=' . (int) $id . ' ORDER BY id' );
	}

	public static function deleteByLayoutId( $id )
	{
		return self::$__CONN__->exec( 'DELETE FROM ' . self::tableNameFromClassName( 'PageText' ) . ' WHERE layout_id=' . (int) $id ) === false ? false : true;
	}

}

// end PageText class