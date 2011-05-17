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
 * Class PagesController
 * 
 * @package frog
 * @subpackage controllers
 *
 * @since 0.1
 */
class PageController extends Controller {

	public function __construct()
	{
		AuthUser::load();
		if ( !AuthUser::isLoggedIn() )
		{
			redirect( get_url( 'login' ) );
		}
		else if ( !AuthUser::hasPermission( 'administrator,developer,editor' ) )
		{
			redirect( URL_PUBLIC );
		}
	}

	public function index()
	{
		$this->setLayout( 'backend' );
		$this->display( 'page/index', array(
			'root' => Record::findByIdFrom( 'Page', 1 ),
			'content_children' => $this->children( 1, 0, true )
		) );
	}

	public function add( $parent_id=1 )
	{
		// check if trying to save
		if ( get_request_method() == 'POST' || get_request_method() == 'AJAX' )
			return $this->_add();

		$data = Flash::get( 'post_data' );
		$page = new Page( $data );
		$page->parent_id = $parent_id;
		$page->status_id = Setting::get( 'default_status_id' );
		$page->needs_login = Page::LOGIN_INHERIT;
		$page->published_on = date( 'Y-m-d H:i:s' );

		$page_parts = Flash::get( 'post_parts_data' );

		if ( empty( $page_parts ) )
		{
			// check if we have a big sister ...
			$big_sister = Record::findOneFrom( 'Page', 'parent_id=? ORDER BY id DESC', array($parent_id) );
			if ( $big_sister )
			{
				// get all is part and create the same for the new little sister
				$big_sister_parts = Record::findAllFrom( 'PagePart', 'page_id=? ORDER BY id ASC', array($big_sister->id) );
				$page_parts = array();
				foreach ( $big_sister_parts as $parts )
				{
					$page_parts[] = new PagePart( array(
								'name' => $parts->name,
								'filter_id' => Setting::get( 'default_filter_id' )
									) );
				}
			}
			else
			{
				$parent_sister = Record::findOneFrom( 'Page', 'id=?', array($parent_id) );
				if ( $parent_sister )
				{
					// get all is part and create the same for the new little sister
					$parent_sister_parts = Record::findAllFrom( 'PagePart', 'page_id=? ORDER BY id', array($parent_sister->id) );
					$page_parts = array();
					foreach ( $parent_sister_parts as $parts )
					{
						$page_parts[] = new PagePart( array(
									'name' => $parts->name,
									'filter_id' => Setting::get( 'default_filter_id' )
										) );
					}
				}

				//$page_parts = array(new PagePart(array('filter_id' => Setting::get('default_filter_id'))));
			}
		}

		// display things ...
		$this->setLayout( 'backend' );
		$this->display( 'page/edit', array(
			'action' => 'add',
			'page' => $page,
			'tags' => array(),
			'filters' => Filter::findAll(),
			'behaviors' => Behavior::findAll(),
			'page_parts' => $page_parts,
			'layouts' => Record::findAllFrom( 'Layout' ))
		);
	}

	private function _add()
	{
		$data = $_POST['page'];
		Flash::set( 'post_data', (object) $data );

		if ( empty( $data['title'] ) )
		{
			// Rebuilding original page
			$part = $_POST['part'];
			if ( !empty( $part ) )
			{
				$tmp = false;
				foreach ( $part as $key => $val )
				{
					$tmp[$key] = (object) $val;
				}
				$part = $tmp;
			}

			$page = $_POST['page'];
			if ( !empty( $page ) && !array_key_exists( 'is_protected', $page ) )
			{
				$page = array_merge( $page, array('is_protected' => 0) );
			}

			$tags = $_POST['page_tag'];

			Flash::set( 'page', (object) $page );
			Flash::set( 'page_parts', (object) $part );
			Flash::set( 'page_tag', $tags );

			Flash::set( 'error', __( 'You have to specify a title!' ) );
			redirect( get_url( 'page/add' ) );
		}

		/**
		 * Make sure the title doesn't contain HTML
		 * 
		 * @todo Replace this by HTML Purifier?
		 */
		if ( Setting::get( 'allow_html_title' ) == 'off' )
		{
			use_helper( 'Kses' );
			$data['title'] = kses( trim( $data['title'] ), array() );
		}

		$page = new Page( $data );

		// save page data
		if ( $page->save() )
		{
			// get data from user
			$data_parts = $_POST['part'];
			Flash::set( 'post_parts_data', (object) $data_parts );

			foreach ( $data_parts as $data )
			{
				$data['page_id'] = $page->id;
				$data['name'] = trim( $data['name'] );
				$page_part = new PagePart( $data );
				$page_part->save();
			}

			// save tags
			$page->saveTags( $_POST['page_tag']['tags'] );

			Flash::set( 'success', __( 'Page has been saved!' ) );
		}
		else
		{
			if ( get_request_method() == 'AJAX' )
			{
				echo('error');
			}
			else
			{
				Flash::set( 'error', __( 'Page has not been saved!' ) );
				redirect( get_url( 'page/add' ) );
			}
		}

		Observer::notify( 'page_add_after_save', $page );

		if ( get_request_method() == 'AJAX' )
		{
			if ( isset( $_POST['commit'] ) )
				echo(get_url( 'page' ));
			else
				echo(get_url( 'page/edit/' . $page->id ));
		}
		else
		{
			// save and quit or save and continue editing ?
			if ( isset( $_POST['commit'] ) )
				redirect( get_url( 'page' ) );
			else
				redirect( get_url( 'page/edit/' . $page->id ) );
		}
	}

	public function addPart()
	{
		header( 'Content-Type: text/html; charset: utf-8' );

		$data = isset( $_POST ) ? $_POST : array();
		$data['name'] = isset( $data['name'] ) ? trim( $data['name'] ) : '';
		$data['index'] = isset( $data['index'] ) ? (int) $data['index'] : 1;

		echo $this->_getPartView( $data['index'], $data['name'] );
	}

	public function edit( $id=null )
	{
		if ( is_null( $id ) )
			redirect( get_url( 'page' ) );

		$page = Page::findById( $id );

		if ( !$page )
		{
			Flash::set( 'error', __( 'Page not found!' ) );
			redirect( get_url( 'page' ) );
		}

		// check for protected page and editor user
		if ( !AuthUser::hasPermission( 'administrator' ) && !AuthUser::hasPermission( 'developer' ) && $page->is_protected )
		{
			Flash::set( 'error', __( 'You do not have permission to access the requested page!' ) );
			redirect( get_url( 'page' ) );
		}

		// check if trying to save
		if ( get_request_method() == 'POST' || get_request_method() == 'AJAX' )
			return $this->_edit( $id );

		// find all page_part of this pages

		$page_parts = PagePart::getParts( $page );


		/* TODO: надо ли?
		  if ( empty( $page_parts ) )
		  $page_parts = array();
		 */
		// display things ...
		$this->setLayout( 'backend' );
		$this->display( 'page/edit', array(
			'action' => 'edit',
			'page' => $page,
			'tags' => $page->getTags(),
			'filters' => Filter::findAll(),
			'behaviors' => Behavior::findAll(),
			'parts' => $page_parts,
			'layouts' => Record::findAllFrom( 'Layout', '1=1 ORDER BY position' ))
		);
	}

	private function _edit( $id )
	{
		$data = $_POST['page'];

		$page = Record::findByIdFrom( 'Page', $id );

		// need to do this because the use of a checkbox
		$data['is_protected'] = !empty( $data['is_protected'] ) ? 1 : 0;

		/**
		 * Make sure the title doesn't contain HTML
		 *
		 * @todo Replace this by HTML Purifier?
		 */
		if ( Setting::get( 'allow_html_title' ) == 'off' )
		{
			use_helper( 'Kses' );
			$data['title'] = kses( trim( $data['title'] ), array() );
		}

		$page->setFromData( $data );

		Observer::notify( 'page_edit_before_save', $page );

		if ( $page->save() )
		{
			// get data for parts of this page
			$data_parts = $_POST['part'];

			foreach ( $data_parts as $data )
			{
				$part_class = Inflector::camelize( 'page_' . $data['name'] );
				unset( $data['name'] );

				$part = new $part_class( $data );
				$part->page_id = $id;
				$part->save();
			}

			// save tags
			$page->saveTags( $_POST['page_tag']['tags'] );

			Flash::set( 'success', __( 'Page has been saved!' ) );
		}
		else
		{
			if ( get_request_method() == 'AJAX' )
			{
				echo('error');
			}
			else
			{
				Flash::set( 'error', __( 'Page has not been saved!' ) );
				redirect( get_url( 'page/edit/' . $id ) );
			}
		}

		Observer::notify( 'page_edit_after_save', $page );

		if ( get_request_method() == 'AJAX' )
		{
			if ( isset( $_POST['commit'] ) )
				echo(get_url( 'page' ));
			else
				echo(get_url( 'page/edit/' . $id ));
		}
		else
		{
			// save and quit or save and continue editing ?
			if ( isset( $_POST['commit'] ) )
				redirect( get_url( 'page' ) );
			else
				redirect( get_url( 'page/edit/' . $id ) );
		}
	}

	/**
	 * Used to delete a page.
	 * 
	 * TODO - make sure we not only delete the page but also all parts and all children!
	 *
	 * @param int $id Id of page to delete
	 */
	public function delete( $id )
	{
		// security (dont delete the root page)
		if ( $id > 1 )
		{
			// find the page to delete
			if ( $page = Record::findByIdFrom( 'Page', $id ) )
			{
				// check for permission to delete this page
				if ( !AuthUser::hasPermission( 'administrator' ) && !AuthUser::hasPermission( 'developer' ) && $page->is_protected )
				{
					Flash::set( 'error', __( 'You do not have permission to access the requested page!' ) );
					redirect( get_url( 'page' ) );
				}

				// need to delete all page_parts too !!
				PagePart::deleteParts( $page );

				if ( $page->delete() )
				{
					Observer::notify( 'page_delete', $page );
					Flash::set( 'success', __( 'Page :title has been deleted!', array(':title' => $page->title) ) );
				}
				else
					Flash::set( 'error', __( 'Page :title has not been deleted!', array(':title' => $page->title) ) );
			}
			else
				Flash::set( 'error', __( 'Page not found!' ) );
		}
		else
			Flash::set( 'error', __( 'Action disabled!' ) );

		redirect( get_url( 'page' ) );
	}

	public function children( $parent_id, $level, $return=false )
	{
		$expanded_rows = isset( $_COOKIE['expanded_rows'] ) ? explode( ',', $_COOKIE['expanded_rows'] ) : array();

		// get all children of the page (parent_id)
		$childrens = Page::childrenOf( $parent_id );

		foreach ( $childrens as $index => $child )
		{
			$childrens[$index]->has_children = Page::hasChildren( $child->id );
			$childrens[$index]->is_expanded = in_array( $child->id, $expanded_rows );

			if ( $childrens[$index]->is_expanded )
				$childrens[$index]->children_rows = $this->children( $child->id, $level + 1, true );
		}

		$content = new View( 'page/children', array(
					'childrens' => $childrens,
					'level' => $level + 1,
						) );

		if ( $return )
			return $content;

		echo $content;
	}

	/**
	 * Ajax action to reorder (page->position) a page
	 *
	 * all the child of the new page->parent_id have to be updated
	 * and all nested tree has to be rebuild
	 */
	public function reorder( $parent_id )
	{
		if ( !empty( $_POST['pages'] ) )
		{
			$pages = $_POST['pages'];

			foreach ( $pages as $position => $page_id )
			{
				$page = Record::findByIdFrom( 'Page', $page_id );
				$page->position = (int) $position;
				$page->parent_id = (int) $parent_id;
				$page->save();
			}
		}
	}

	/**
	 * Ajax action to copy a page or page tree
	 *
	 */
	public function copy( $parent_id )
	{
		if ( !empty( $_POST['pages'] ) )
		{
			$pages = $_POST['pages'];
			$dragged_id = (int) $_POST['dragged_id'];

			$page = Record::findByIdFrom( 'Page', $dragged_id );
			$new_root_id = Page::cloneTree( $page, $parent_id );

			foreach ( $pages as $position => $page_id )
			{
				if ( $page_id == $dragged_id )
				{
					/* Move the cloned tree, not original. */
					$page = Record::findByIdFrom( 'Page', $new_root_id );
				}
				else
				{
					$page = Record::findByIdFrom( 'Page', $page_id );
				}

				$page->position = (int) $position;
				$page->parent_id = (int) $parent_id;
				$page->save();
			}

			echo json_encode( array('new_root_id' => $new_root_id) );
		}
	}

	public function newtab_dialog()
	{
		echo new View( 'page/newtab_dialog' );
	}

	public function link_dialog()
	{
		echo new View( 'page/link_dialog', array(
			'root' => Record::findByIdFrom( 'Page', 1 ),
			'children_content' => $this->link_dialog_children( 1, 0, true )
				) );
	}

	public function link_dialog_children( $parent_id, $level, $return=false )
	{
		//$expanded_rows = isset($_COOKIE['expanded_rows']) ? explode(',', $_COOKIE['expanded_rows']): array();
		// get all children of the page (parent_id)
		$childrens = Page::childrenOf( $parent_id );

		foreach ( $childrens as $index => $child )
		{
			$childrens[$index]->has_children = Page::hasChildren( $child->id );
			//$childrens[$index]->is_expanded = in_array($child->id, $expanded_rows);
			//if( $childrens[$index]->is_expanded )
			$childrens[$index]->children_rows = $this->link_dialog_children( $child->id, $level + 1, true );
		}

		$content = new View( 'page/link_dialog_children', array(
					'childrens' => $childrens,
					'level' => $level + 1,
						) );

		if ( $return )
			return $content;

		echo $content;
	}

	//  Private methods  -----------------------------------------------------


	private function _getPartView( $index=1, $name='', $filter_id='', $content='' )
	{
		$page_part = new PagePart( array(
					'name' => $name,
					'filter_id' => $filter_id,
					'content' => $content
						) );

		return $this->render( 'page/part_edit', array(
			'index' => $index,
			'page_part' => $page_part
		) );
	}

}

// end PageController class
