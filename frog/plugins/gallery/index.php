<?php if(!defined('DEBUG')) die;

if( FROG_BACKEND )
{
	// Autoload model
	AutoLoader::addFile('Gallery', CORE_ROOT . '/plugins/gallery/models/Gallery.php');
	
	Plugin::addController('gallery');
	
	/*
	// filter_content event
	function filter_content_handler( $content )
	{
		
	}
	
	Observer::observe('filter_content', 'filter_content_handler');
	*/
}

?>