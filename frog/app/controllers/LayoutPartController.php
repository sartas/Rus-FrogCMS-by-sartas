<?php

if ( !defined( 'DEBUG' ) )
	die;


class LayoutPartController extends Controller {

	public function __construct()
	{
		AuthUser::load();
		if ( !AuthUser::isLoggedIn() )
		{
			redirect( get_url( 'login' ) );
		}
		else if ( !AuthUser::hasPermission( 'administrator,developer' ) )
		{
			redirect( URL_PUBLIC );
		}
	}

	public function delete( $id )
	{
		if ( $part = Record::findByIdFrom( 'LayoutPart', $id ) )
		{

			if ( $part->delete() )
			{
				echo $this->renderJSON( true );
			}
			else
			{
				echo $this->renderJSON( false );
			}
		}
		else
		{
			echo $this->renderJSON( false );
		}
	}

	public function edit_dialog( $id )
	{
		$part = LayoutPart::findByIdFrom( 'LayoutPart', $id );

		echo new View( 'layout_part/edit_dialog', array('part' => $part) );
	}

	public function add( $layout_id )
	{
		$data = $_POST['part'];

		$part = new LayoutPart( $data );
		$part->layout_id = $layout_id;

		if ( $part->save() )
		{
			echo $this->renderJSON( $part );
		}
		else
		{
			echo $this->renderJSON( false );
		}
	}

	public function add_dialog( $layout_id )
	{
		$part = new LayoutPart( );
		$part->layout_id = $layout_id;

		echo new View( 'layout_part/edit_dialog', array('part' => $part) );
	}

	public function edit( $id )
	{
		$data = $_POST['part'];

		$part = new LayoutPart( $data );
		$old_part = Record::findByIdFrom( 'LayoutPart', $id );

		$part->id = $old_part->id;
		$part->layout_id = $old_part->layout_id;

		if ( $part->save() )
		{
			echo $this->renderJSON( $part );
		}
		else
		{
			echo $this->renderJSON( false );
		}
	}

}

// end class
