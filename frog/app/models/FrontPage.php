<?php

if ( !defined( 'DEBUG' ) )
	die;

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
 * class Page
 *
 * apply methodes for page, layout and snippet of a page
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since  0.1
 *
 * -- TAGS --
 * id()
 * title()
 * breadcrumb()
 * author()
 * slug()
 * url()
 *
 * link([label], [class])
 * date([format])
 *
 * hasContent(part_name, [inherit])
 * content([part_name], [inherit])
 * breadcrumbs([between])
 *
 * children([arguments :limit :offset :order])
 * find(url)

  todo:

  <r:navigation />

  Renders a list of links specified in the urls attribute according to three states:

  normal specifies the normal state for the link
  here specifies the state of the link when the url matches the current page�s URL
  selected specifies the state of the link when the current page matches is a child of the specified url
  The between tag specifies what should be inserted in between each of the links.

  Usage:
  <r:navigation urls="[Title: url | Title: url | ...]">
  <r:normal><a href="<r:url />"><r:title /></a></r:normal>
  <r:here><strong><r:title /></strong></r:here>
  <r:selected><strong><a href="<r:url />"><r:title /></a></strong></r:selected>
  <r:between> | </r:between>
  </r:navigation>

 * */
class FrontPage {
	const STATUS_DRAFT = 1;
	const STATUS_REVIEWED = 50;
	const STATUS_PUBLISHED = 100;
	const STATUS_HIDDEN = 101;

	const LOGIN_NOT_REQUIRED = 0;
	const LOGIN_REQUIRED = 1;
	const LOGIN_INHERIT = 2;

	public $id;
	public $title = '';
	public $breadcrumb;
	public $author;
	public $author_id;
	public $updator;
	public $updator_id;
	public $slug = '';
	public $keywords = '';
	public $description = '';
	public $url = '';
	public $parent = false;
	public $level = false;
	public $tags = false;
	public $parts = false;
	public $needs_login;

	public function __construct( $object, $parent )
	{
		$this->parent = $parent;

		foreach ( $object as $key => $value )
		{
			$this->$key = $value;
		}

		if ( $this->parent )
		{
			$this->setUrl();
		}

		// ���������		
		$this->level = $this->level();
	}

	protected function setUrl()
	{
		$this->url = trim( $this->parent->url . '/' . $this->slug, '/' );
	}

	public function id()
	{
		return $this->id;
	}

	public function title()
	{
		return $this->title;
	}

	public function breadcrumb()
	{
		return $this->breadcrumb;
	}

	public function author()
	{
		return $this->author;
	}

	public function authorId()
	{
		return $this->author_id;
	}

	public function updator()
	{
		return $this->updator;
	}

	public function updatorId()
	{
		return $this->updator_id;
	}

	public function slug()
	{
		return $this->slug;
	}

	public function keywords()
	{
		return $this->keywords;
	}

	public function description()
	{
		return $this->description;
	}

	public function url()
	{
		return BASE_URL . $this->url . ($this->url != '' ? URL_SUFFIX : '');
	}

	public function level()
	{
		if ( $this->level === false )
			$this->level = empty( $this->url ) ? 0 : substr_count( $this->url, '/' ) + 1;

		return $this->level;
	}

	public function tags()
	{
		if ( !$this->tags )
			$this->_loadTags();

		return $this->tags;
	}

	public function link( $label=null, $options='' )
	{
		if ( $label == null )
			$label = $this->title();

		return sprintf( '<a href="%s" %s>%s</a>', $this->url(), $options, $label
		);
	}

	/**
	 * http://php.net/strftime
	 * exemple (can be useful):
	 *  '%a, %e %b %Y'      -> Wed, 20 Dec 2006 <- (default)
	 *  '%A, %e %B %Y'      -> Wednesday, 20 December 2006
	 *  '%B %e, %Y, %H:%M %p' -> December 20, 2006, 08:30 pm
	 */
	public function date( $format='%d-%m-%Y, %H:%M', $which_one='publish' )
	{
		if ( $which_one == 'update' || $which_one == 'updated' )
			return strftime( $format, strtotime( $this->updated_on ) );
		else if ( $which_one == 'publish' || $which_one == 'published' )
			return strftime( $format, strtotime( $this->published_on ) );
		else
			return strftime( $format, strtotime( $this->created_on ) );
	}

	public function breadcrumbs( $separator='&gt;' )
	{
		$url = '';
		$path = '';
		$paths = explode( '/', '/' . $this->slug );
		$nb_path = count( $paths );

		$out = '<div class="breadcrumb">' . "\n";

		if ( $this->parent )
			$out .= $this->parent->_inversedBreadcrumbs( $separator );

		return $out . '<span class="breadcrumb-current">' . $this->breadcrumb() . '</span></div>' . "\n";
	}

	public function hasContent( $part_name )
	{
		if ( !$this->parts )
			$this->parts = self::getParts( $this );

		if ( isset( $this->parts[$part_name] ) )
		{
			return true;
		}
	}

	public function content( $part_name='body' )
	{
		if ( !$this->parts )
			$this->parts = self::getParts( $this );

		if ( isset( $this->parts[$part_name] ) )
			return $this->parts[$part_name]->content();
		/*



		  try
		  {
		  ob_start();
		  $eval_state = eval( '?>' . $this->part->$part->content_html );
		  $out = ob_get_contents();
		  ob_end_clean();

		  if ( $eval_state !== false )
		  {
		  return $out;
		  }
		  else
		  {
		  throw new Exception( 'Please, check PHP code at content part "' . $part . '" of page with ID: ' . $this->id . ' and title "' . $this->title() . '"' );
		  }
		  } catch ( Exception $e )
		  {
		  if ( DEBUG )
		  {
		  return '[CONTENT ERROR: ' . $e->getMessage() . ']';
		  }
		  else
		  {
		  return '[CONTENT ERROR]';
		  }
		  }
		  }
		  else if ( $inherit && $this->parent )
		  {
		  return $this->parent->content( $part, true );
		  }
		 */
	}

	public function previous()
	{
		if ( $this->parent )
			return $this->parent->children( array(
				'limit' => 1,
				'where' => 'page.id < ' . $this->id,
				'order' => 'page.created_on DESC'
			) );
	}

	public function next()
	{
		if ( $this->parent )
			return $this->parent->children( array(
				'limit' => 1,
				'where' => 'page.id > ' . $this->id,
				'order' => 'page.created_on ASC'
			) );
	}

	public function children( $args=null, $value=array(), $include_hidden=false )
	{
		$conn = Record::getConnection();

		$page_class = 'FrontPage';

		// Collect attributes...
		$where = isset( $args['where'] ) ? $args['where'] : '';
		$order = isset( $args['order'] ) ? $args['order'] : 'page.position, page.id';
		$offset = isset( $args['offset'] ) ? $args['offset'] : 0;
		$limit = isset( $args['limit'] ) ? $args['limit'] : 0;

		// auto offset generated with the page param
		if ( $offset == 0 && isset( $_GET['page'] ) )
			$offset = ((int) $_GET['page'] - 1) * $limit;

		// Prepare query parts
		$where_string = trim( $where ) == '' ? '' : "AND " . $where;
		$limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';

		// Prepare SQL
		$sql = 'SELECT page.*, author.name AS author, author.id AS author_id, updator.name AS updator, updator.id AS updator_id '
				. 'FROM ' . TABLE_PREFIX . 'page AS page '
				. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS author ON author.id = page.created_by_id '
				. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS updator ON updator.id = page.updated_by_id '
				. 'WHERE parent_id = ' . $this->id . ' AND (status_id=' . FrontPage::STATUS_REVIEWED . ' OR status_id=' . FrontPage::STATUS_PUBLISHED . ($include_hidden ? ' OR status_id=' . FrontPage::STATUS_HIDDEN : '') . ') '
				. "$where_string ORDER BY $order $limit_string";

		$pages = array();

		// hack to be able to redefine the page class with behavior
		if ( !empty( $this->behavior_id ) )
		{
			// will return Page by default (if not found!)
			$page_class = Behavior::loadPageHack( $this->behavior_id );
		}

		// Run!
		if ( $stmt = $conn->prepare( $sql ) )
		{
			$stmt->execute( $value );

			while ( $object = $stmt->fetchObject() )
			{
				$page = new $page_class( $object, $this );

				// assignParts
				//$page->part = self::getParts( $page->id );
				$pages[] = $page;
			}
		}

		if ( $limit == 1 )
			return isset( $pages[0] ) ? $pages[0] : false;

		return $pages;
	}

	public function childrenCount( $args=null, $value=array(), $include_hidden=false )
	{
		$conn = Record::getConnection();

		// Collect attributes...
		$where = isset( $args['where'] ) ? $args['where'] : '';
		$order = isset( $args['order'] ) ? $args['order'] : 'position, id';
		$limit = isset( $args['limit'] ) ? $args['limit'] : 0;
		$offset = 0;

		// Prepare query parts
		$where_string = trim( $where ) == '' ? '' : "AND " . $where;
		$limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';

		// Prepare SQL
		$sql = 'SELECT COUNT(*) AS nb_rows FROM ' . TABLE_PREFIX . 'page '
				. 'WHERE parent_id = ' . $this->id . ' AND (status_id=' . FrontPage::STATUS_REVIEWED . ' OR status_id=' . FrontPage::STATUS_PUBLISHED . ($include_hidden ? ' OR status_id=' . FrontPage::STATUS_HIDDEN : '') . ') '
				. "$where_string ORDER BY $order $limit_string";

		$stmt = $conn->prepare( $sql );
		$stmt->execute( $value );

		return (int) $stmt->fetchColumn();
	}

	public static function findBySlug( $slug, $parent )
	{
		static $pages_cache = array();

		$page_cache_id = (is_array( $slug ) ? join( $slug ) : $slug) . (isset( $parent->id ) ? $parent->id : 0);

		if ( !isset( $pages_cache[$page_cache_id] ) )
		{
			$connection = Record::getConnection();

			$page_class = 'FrontPage';

			$parent_id = $parent ? $parent->id : 0;

			$sluged = $slug;

			if ( is_array( $slug ) )
			{
				$sql = 'SELECT page.*, author.name AS author, updator.name AS updator '
						. 'FROM ' . TABLE_PREFIX . 'page AS page '
						. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS author ON author.id = page.created_by_id '
						. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS updator ON updator.id = page.updated_by_id '
						. 'WHERE slug IN(?) AND parent_id = ? AND (status_id=' . FrontPage::STATUS_REVIEWED . ' OR status_id=' . FrontPage::STATUS_PUBLISHED . ' OR status_id=' . FrontPage::STATUS_HIDDEN . ')';

				$sluged = join( '","', $slug );
			}
			else
			{
				$sql = 'SELECT page.*, author.name AS author, updator.name AS updator '
						. 'FROM ' . TABLE_PREFIX . 'page AS page '
						. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS author ON author.id = page.created_by_id '
						. 'LEFT JOIN ' . TABLE_PREFIX . 'user AS updator ON updator.id = page.updated_by_id '
						. 'WHERE slug = ? AND parent_id = ? AND (status_id=' . FrontPage::STATUS_REVIEWED . ' OR status_id=' . FrontPage::STATUS_PUBLISHED . ' OR status_id=' . FrontPage::STATUS_HIDDEN . ')';
			}

			$stmt = $connection->prepare( $sql );

			$stmt->execute( array($sluged, $parent_id) );

			if ( is_array( $slug ) )
			{
				$pages = array();

				while ( $page = $stmt->fetchObject() )
				{
					// hook to be able to redefine the page class with behavior
					if ( !empty( $parent->behavior_id ) )
					{
						// will return Page by default (if not found!)
						$page_class = Behavior::loadPageHack( $parent->behavior_id );
					}

					// create the object page
					$page = new $page_class( $page, $parent );

					// assign all is parts
					//$page->part = get_parts( $page->id );

					$pages[] = $page;
				}

				$pages_cache[$page_cache_id] = $pages;

				return $pages;
			}
			else
			{
				if ( $page = $stmt->fetchObject() )
				{
					// hook to be able to redefine the page class with behavior
					if ( !empty( $parent->behavior_id ) )
					{
						// will return Page by default (if not found!)
						$page_class = Behavior::loadPageHack( $parent->behavior_id );
					}

					// create the object page
					$page = new $page_class( $page, $parent );

					// assign all is parts
					//$page->part = get_parts( $page->id );

					$pages_cache[$page_cache_id] = $page;

					return $page;
				}
				else
					return false;
			}
		}
		else
		{
			return $pages_cache[$page_cache_id];
		}
	}

	public static function find( $uri )
	{
		$uri = trim( $uri, '/' );

		$has_behavior = false;

		// adding the home root
		$urls = array_merge( array(''), explode_uri( $uri ) );
		$url = '';

		$page = new stdClass;
		$page->id = 0;

		$parent = false;

		foreach ( $urls as $page_slug )
		{
			$url = ltrim( $url . '/' . $page_slug, '/' );

			if ( $page = find_page_by_slug( $page_slug, $parent ) )
			{
				// check for behavior
				if ( $page->behavior_id != '' )
				{
					// add a instance of the behavior with the name of the behavior 
					$params = explode_uri( substr( $uri, strlen( $url ) ) );
					$page->{$page->behavior_id} = Behavior::load( $page->behavior_id, $page, $params );

					return $page;
				}
			}
			else
			{
				break;
			}

			$parent = $page;
		} // foreach

		return (!$page && $has_behavior) ? $parent : $page;
	}

	public static function getParts( $page, $get_content = true )
	{
		$page_parts = array();
		foreach ( LayoutPart::findAllByLayoutId( $page->layout_id ) as $layout_part )
		{
			$part_class = self::getPartClass( $layout_part->type );

			$part = new $part_class();
			if ( $get_content && $tmp_part = $part::findOneByPartIdPageId( $layout_part->id, $page->id ) )
			{
				$part = $tmp_part;
			}
			else
			{
				$part->part_id = $layout_part->id;
			}
			$part->type = $layout_part->type;
			$part->name = $layout_part->name;
			$part->title = $layout_part->title;

			$page_parts[$part->name] = $part;
		}
		return $page_parts;
	}

	public static function getPartClass( $type )
	{
		return Inflector::camelize( 'part_' . $type );
	}

	public static function deleteParts( $page )
	{
		$parts = self::getParts( $page );
		if ( !empty( $parts ) )
		{
			foreach ( $parts as $part )
			{
				$part->delete();
			}
		}
	}

	/*
	  public static function getParts( $page_id = null )
	  {
	  $connection = Record::getConnection();

	  $page_id = ($page_id === null ? $this->id : $page_id);

	  $objPart = new stdClass;

	  $sql = 'SELECT name, content_html FROM ' . TABLE_PREFIX . 'page_part WHERE page_id=?';

	  if ( $stmt = $connection->prepare( $sql ) )
	  {
	  $stmt->execute( array($page_id) );

	  while ( $part = $stmt->fetchObject() )
	  $objPart->{$part->name} = $part;
	  }

	  return $objPart;
	  }
	 */

	public function parent( $level=null )
	{
		if ( $level === null )
			return $this->parent;

		if ( $level > $this->level )
			return false;
		else if ( $this->level == $level )
			return $this;
		else
			return $this->parent->parent( $level ); // 0.9.6-RU alpha
	}

	public function includeSnippet( $name )
	{
		if ( isset( $this->snippet[$name] ) )
		{
			eval( '?>' . $this->snippet[$name]->content_html );
			return;
		}

		$connection = Record::getConnection();

		$sql = 'SELECT content_html FROM ' . TABLE_PREFIX . 'snippet WHERE name LIKE ?';

		$stmt = $connection->prepare( $sql );
		$stmt->execute( array($name) );

		if ( $snippet = $stmt->fetchObject() )
		{
			eval( '?>' . $snippet->content_html );
			$this->snippet[$name] = $snippet;
		}
	}

	public function executionTime()
	{
		return execution_time();
	}

	// Private --------------------------------------------------------------

	private function _inversedBreadcrumbs( $separator )
	{
		$out = '<a href="' . $this->url() . '" title="' . $this->breadcrumb . '">' . $this->breadcrumb . '</a> <span class="breadcrumb-separator">' . $separator . '</span> ' . "\n";

		if ( $this->parent )
			return $this->parent->_inversedBreadcrumbs( $separator ) . $out;

		return $out;
	}

	private function _executeLayout()
	{
		$connection = Record::getConnection();

		$sql = 'SELECT content_type, content FROM ' . TABLE_PREFIX . 'layout WHERE id = ?';

		$stmt = $connection->prepare( $sql );
		$stmt->execute( array($this->_getLayoutId()) );

		if ( $layout = $stmt->fetchObject() )
		{
			// if content-type not set, we set html as default
			if ( $layout->content_type == '' )
				$layout->content_type = 'text/html';

			// set content-type and charset of the page
			header( 'Content-Type: ' . $layout->content_type . '; charset=UTF-8' );

			ob_start();
			// execute the layout code
			eval( '?>' . $layout->content );
			ob_end_flush();
		}
	}

	public function display()
	{
		$this->_executeLayout();
	}

	/**
	 * find the layoutId of the page where the layout is set
	 */
	private function _getLayoutId()
	{
		if ( $this->layout_id )
			return $this->layout_id;
		else if ( $this->parent )
			return $this->parent->_getLayoutId();
		else
			exit( 'You need to set a layout!' );
	}

	/**
	 * Finds the "login needed" status for the page.
	 *
	 * @return int Integer corresponding to one of the LOGIN_* constants.
	 */
	public function getLoginNeeded()
	{
		if ( $this->needs_login == FrontPage::LOGIN_INHERIT && $this->parent )
			return $this->parent->getLoginNeeded();
		else
			return $this->needs_login;
	}

	private function _loadTags()
	{
		$conn = Record::getConnection();
		$this->tags = array();

		$sql = "SELECT tag.id AS id, tag.name AS tag FROM " . TABLE_PREFIX . "page_tag AS page_tag, " . TABLE_PREFIX . "tag AS tag " .
				"WHERE page_tag.page_id={$this->id} AND page_tag.tag_id = tag.id";

		if ( !$stmt = $conn->prepare( $sql ) )
			return;

		$stmt->execute();

		// Run!
		while ( $object = $stmt->fetchObject() )
			$this->tags[$object->id] = $object->tag;
	}

	public static function uriMatch( $uri )
	{
		$uri = trim( $uri, '/' );

		if ( CURRENT_URI == $uri )
			return true;

		return false;
	}

	public static function explodeUri( $uri )
	{
		return preg_split( '/\//', $uri, -1, PREG_SPLIT_NO_EMPTY );
	}

	public static function uriStartWith( $uri )
	{
		$url = trim( $uri, '/' );

		if ( CURRENT_URI == $uri )
			return true;

		if ( strpos( CURRENT_URI, $uri ) === 0 )
			return true;

		return false;
	}

}

// end FrontPage class



/*
  Backward compatibility
 */

// Functions from main.php

function find_page_by_uri( $uri )
{
	return FrontPage::find( $uri );
}

function find_page_by_slug( $slug, $parent = null )
{
	return FrontPage::findBySlug( $slug, $parent );
}

function url_match( $url )
{
	return FrontPage::uriMatch( $url );
}

function get_parts( $page_id )
{
	return FrontPage::getParts( $page_id );
}

function explode_uri( $uri )
{
	return FrontPage::explodeUri( $uri );
}

function url_start_with( $url )
{
	return FrontPage::uriStartWith( $url );
}

?>