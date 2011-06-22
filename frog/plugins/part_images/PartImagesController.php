<?php

class PartImagesController extends PluginController {

	public function add( $page_id, $part_id )
	{
		echo $this->display( 'part_images/views/add_form', array(
			'page_id' => $page_id,
			'part_id' => $part_id
		) );
	}

	public function upload( $page_id, $part_id )
	{
		if ( !isset( $_SESSION['ai_uploaded'] ) )
			$_SESSION['ai_uploaded'] = array();

		$max_uploaded_width = 1000;
		$max_uploaded_height = 1000;

		$gallery_dir = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery/' . $page_id;

		if ( !is_dir( $gallery_dir ) )
		{
			mkdir( $gallery_dir, 0755, true );
		}
		$file_name = microtime( true ) . '-' . preg_replace( '/[^a-z0-9\.]/i', '', $_FILES['Filedata']['name'] );

		use_helper( 'Dir' );

		$image_file = new DirFileImage( $_FILES['Filedata']['tmp_name'] );

		if ( $image_file->getWidth() > $max_uploaded_width || $image_file->getHeight() > $max_uploaded_height )
		{
			if ( $image_file->getWidth() > $image_file->getHeight() )
				$image_file->resizeToWidth( $max_uploaded_width );
			else
				$image_file->resizeToHeight( $max_uploaded_height );
		}

		$image_file->save( $gallery_dir . '/' . $file_name );

		$image = new PartImages();
		$image->alternate = $file_name;
		$image->file_name = $file_name;
		$image->page_id = $page_id;
		$image->part_id = $part_id;
		//$image->width = $image_file->getWidth();
		//$image->height = $image_file->getHeight();

		if ( $image->save() )
		{
			$_SESSION['ai_uploaded'][] = $image->id;

			echo json_encode( true );
		}
		else
		{
			echo json_encode( false );
		}
	}

	public function get_uploaded( $page_id, $part_id )
	{
		if ( !empty( $_SESSION['ai_uploaded'] ) )
		{
			$images = Record::findAllFrom( 'FrontPartImages', 'page_id="' . (int) $page_id . '" AND part_id="' . (int) $part_id . '" AND id IN(' . join( ',', $_SESSION['ai_uploaded'] ) . ')' );

			$out_images = array();

			foreach ( $images as $item )
			{
				$out_images[] = array(
					'id' => $item->id,
					'file_name' => $item->file_name,
					'url' => $item->url(),
					'thumb' => $item->thumb( 80, 80 ),
					'alternate' => $item->alternate
				);
			}

			$_SESSION['ai_uploaded'] = array();

			echo json_encode( $out_images );
		}
		else
		{
			echo json_encode( false );
		}
	}

	public function delete( $image_id )
	{
		$result = Record::deleteWhere('PartImages', 'id="' . (int) $image_id . '"' );

		if ( $result )
		{
			echo json_encode( $image_id );
		}
		else
		{
			echo json_encode( false );
		}
	}

}

?>