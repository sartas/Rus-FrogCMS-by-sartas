<?php

class GalleryController extends PluginController
{
	public function gallery_upload()
	{
		$_SESSION['gallery_uploaded_files'] = array();
	
		echo new View('../../plugins/gallery/views/gallery_upload');
	}
	
	public function upload_files()
	{
		if( !isset($_SESSION['gallery_uploaded_files']) )
			$_SESSION['gallery_uploaded_files'] = array();
	
		file_put_contents( FROG_ROOT . '/' . 'test.txt', print_r($_FILES, true) );
		
		$gallery_dir = FROG_ROOT . '/' . PUBLIC_FILES . '/gallery';
		
		$file_name = rand(0, 999) . '-' . preg_replace('/[^a-z0-9\.]/i', rand(0,9), $_FILES['Filedata']['name']);
		
		use_helper('Dir');
		
		$image_file = new DirFileImage($_FILES['Filedata']['tmp_name']);
		
		if( $image_file->getWidth() > $image_file->getHeight() )
			$image_file->resizeToWidth(600);
		else
			$image_file->resizeToHeight(600);
			
		$image_file->save( $gallery_dir . '/' . $file_name );
		
		//move_uploaded_file( , $gallery_dir . '/' . $file_name );
		
		$_SESSION['gallery_uploaded_files'][] = $file_name;
		
		echo('true');
	}
	
	public function uploaded_files_names()
	{
		echo json_encode(array('files' => $_SESSION['gallery_uploaded_files']));
	}
}

?>