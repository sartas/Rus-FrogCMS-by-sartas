<?php

AutoLoader::addFile( 'PartImages', PLUGINS_DIR . 'part_images/PartImages.php' );
AutoLoader::addFile( 'FrontPartImages', PLUGINS_DIR . 'part_images/FrontPartImages.php' );

Plugin::addController( 'part_images' );

PagePart::addType( 'images' );

Observer::observe( 'page_add_after_save', 'part_images_page_add_after_save' );

function part_images_page_add_after_save( $page )
{
	if ( !isset( $_POST['part_images'] ) )
		return;

	$page_id = empty( $page->id ) ? 0 : (int) $page->id;

//	$conn = Record::getConnection();
//
//	$sql = 'UPDATE ' . TABLE_PREFIX . 'part_images SET page_id=? WHERE page_id=0';
//	$stmt = $conn->prepare( $sql );
//	$success = $stmt->execute( array($page_id) ) ;
	
	$result = Record::update('PartImages', array('page_id'=>$page_id), 'page_id=0');
	
	if ( $result != false )
	{
		$gallery_dir = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery/';
		rename( $gallery_dir . '0', $gallery_dir . $page->id );
	}
}

?>