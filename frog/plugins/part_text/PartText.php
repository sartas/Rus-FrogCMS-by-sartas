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
class PartText extends PagePart {
	const TABLE_NAME = 'part_text';


	public $part_id = '';
	public $page_id = '';
	public $filter_id = '';
	public $content = '';
	public $content_html = '';

	public function findOneByPartIdPageId( $part_id, $page_id )
	{
		$class = (FROG_BACKEND==true) ? 'PartText':'FrontPartText'; 
		return self::findOneFrom( $class , 'part_id=' . (int) $part_id . ' AND page_id=' . (int) $page_id );
	}

	public function beforeSave()
	{
		//$this->content = stripslashes( $this->content );
		// apply filter to save is generated result in the database
		if ( !empty( $this->filter_id ) )
		{
			$this->content_html = Filter::get( $this->filter_id )->apply( $this->content );

			foreach ( Observer::get( 'filter_content' ) as $callback )
				$this->content_html = call_user_func( $callback, $this->content_html );
		}
		else
			$this->content_html = $this->content;

		return true;
	}

}

// end PartText class
class FrontPartText {
	const TABLE_NAME = 'part_text';
	public $part_id = '';
	public $page_id = '';
	public $filter_id = '';
	public $content = '';
	public $content_html = '';

	public function __construct()
	{
		
	}
	/*
	public function content()
	{
		ob_start();
		$eval_state = eval( '?>' . $this->content_html );
		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}
	 */
	
}
