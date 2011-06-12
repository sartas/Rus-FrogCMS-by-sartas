<?php

if ( !defined( 'DEBUG' ) )
	die;

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

	public function select_type( $parent_id=1 )
	{
		$this->setLayout( 'backend' );
		$this->display( 'page/select_type', array(
			'parent_id' => $parent_id,
			'layouts' => Record::findAllFrom( 'Layout', '1=1 ORDER BY position' )
		) );
	}

	public function add( $parent_id, $layout_id )
	{
		$page = new Page();
		$page->parent_id = $parent_id;
		$page->layout_id = $layout_id;

		// check if trying to save
		if ( get_request_method() == 'AJAX' )
			return $this->_store( 'add', $page );

		$page->status_id = Setting::get( 'default_status_id' );
		$page->needs_login = Page::LOGIN_INHERIT;
		$page->published_on = date( 'Y-m-d H:i:s' );


		$page_parts = FrontPage::getParts( $page, false );




		// display things ...
		$this->setLayout( 'backend' );
		$this->display( 'page/edit', array(
			'action' => 'add',
			'page' => $page,
//			'tags' => array(),
			'filters' => Filter::findAll(),
			'behaviors' => Behavior::findAll(),
			'parts' => $page_parts,
			'layouts' => Record::findAllFrom( 'Layout' ))
		);
	}

	public function edit( $id=null )
	{
		if ( is_null( $id ) )
			redirect( get_url( 'page' ) );

		//$page = Record::findByIdFrom( 'Page', $id );
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
		if ( get_request_method() == 'AJAX' )
			return $this->_store( 'edit', $page );

		// find all page_part of this pages

		$page_parts = FrontPage::getParts( $page );

		// display things ...
		$this->setLayout( 'backend' );
		$this->display( 'page/edit', array(
			'action' => 'edit',
			'page' => $page,
			'filters' => Filter::findAll(),
			'behaviors' => Behavior::findAll(),
			'parts' => $page_parts,
			'layouts' => Record::findAllFrom( 'Layout', '1=1 ORDER BY position' ))
		);
	}

	private function _store( $action, $page )
	{
		$data = $_POST['page'];

		$page->setFromData( $data );
		if ( isset( $page->created_by_name ) )
			unset( $page->created_by_name );
		if ( isset( $page->updated_by_name ) )
			unset( $page->updated_by_name );

		Observer::notify( 'page_' . $action . '_before_save', $page );

		if ( $this->_valid( $page ) )
		{
			if ( $page->save() )
			{

				if ( isset( $_POST['part'] ) )
				{
					$parts = $_POST['part'];
					foreach ( (array) $parts as $data )
					{
						$part_class = FrontPage::getPartClass( $data['type'] );

						$part = new $part_class( $data );
						$part->page_id = $page->id;
						unset( $part->type );
						$part->save();
					}
				}

				$success = __( 'Page :title has been saved!', array(':title' => $page->title) );

				if ( isset( $_POST['commit'] ) )
				{
					Flash::set( 'success', $success );
					Flash::json( 'redirect', get_url( 'page' ) );
				}
				else
				{
					if ( $action == 'add' )
					{
						Flash::set( 'success', $success );
						Flash::json( 'redirect', get_url( 'page/edit/' . $page->id ) );
					}
					else
					{
						Flash::json( 'success', $success );
					}
				}


				Observer::notify( 'page_' . $action . '_after_save', $page );
			}
			else
			{
				$error = __( 'Page :title has not been saved!', array(':title' => $page->title) );
				Flash::json( 'error', $error );
			}
		}
		else
		{
			$error = implode( '<br />', $this->errors );
			$redirect = ($action == 'add') ?
					'page/add/' . $page->parent_id . '/' . $page->layout_id :
					'page/edit/' . $page->id;

			if ( get_request_method() == 'AJAX' )
			{
				echo json_encode( array('error' => $error) );
			}
			else
			{
				Flash::set( 'error', $error );
				redirect( get_url( $redirect ) );
			}
		}
	}

	/**
	 * Validate page object
	 * 
	 * @param object $page 
	 * @return mixed Errors array or true
	 */
	private function _valid( $page )
	{
		// Sanity checks
		// need to do this because the use of a checkbox
		$page->is_protected = !empty( $page->is_protected ) ? 1 : 0;

		// Add pre-save checks here
		$errors = false;

		$page->title = trim( $page->title );
		if ( empty( $page->title ) )
		{
			$errors[] = __( 'You have to specify a title!' );
		}

		// Make sure the title doesn't contain HTML
		if ( Setting::get( 'allow_html_title' ) == 'off' )
		{
			//	use_helper( 'Kses' );
			$page->title = htmlspecialchars( $page->title, ENT_QUOTES );
		}
		$page->breadcrumb = trim( $page->breadcrumb );
		if ( empty( $page->breadcrumb ) )
		{
			$page->breadcrumb = $page->title;
		}

		$page->slug = trim( $page->slug );

		if ( (!isset( $page->id ) || $page->id != 1 ) )
		{
			if ( $page->slug == '' )
				$page->slug = $page->title;
			//translit
			if ( Setting::get( 'translit_slug' ) == 'on' )
			{
				$page->slug = I18n::translit( $page->slug );
			}

			use_helper( 'Sanitize' );

			$page->slug = Sanitize::slug( $page->slug );
		}
		else
		{
			// TODO slug validate if needed
		}

		if ( $page->slug == ADMIN_DIR && $page->parent_id == 1 )
		{
			$errors[] = __( 'You cannot have a slug named :slug!', array(':slug' => ADMIN_DIR) );
		}

		if ( $errors !== false )
		{
			$this->errors = $errors;
			return false;
		}
		else
		{
			return true;
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
				FrontPage::deleteParts( $page );

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
//		print_r( $_POST );
//		exit;
		if ( !empty( $_POST['pages'] ) )
		{
			$pages = $_POST['pages'];
			$dragged_id = (int) $_POST['dragged_id'];

			$page = Record::findByIdFrom( 'Page', $dragged_id );
			$receive_page_title = $page->title;

			// fix recursive copy bug
			if ( $dragged_id == $parent_id )
			{
				echo json_encode( array('error' => __( 'Page :title has not been copied!', array(':title' => $receive_page_title) )) );
				exit;
			}

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

			echo json_encode( array('success' => __( 'Page :title has been copied!', array(':title' => $receive_page_title) ),
				'new_root_id' => $new_root_id) );
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

	/*
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
	 */
}

// end PageController class
