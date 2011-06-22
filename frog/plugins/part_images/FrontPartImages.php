<?php


class FrontPartImages {
	const TABLE_NAME = 'part_images';

	public $part_id;
	public $page_id;
	//public $images;
	public $file_name;
	public $alternate;


	public function content()
	{
		return $this->images;
	}

	public function url()
	{
		return URL_PUBLIC . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . $this->file_name;
	}

	public function thumb( $width = null, $height = null )
	{
		if ( Plugin::isEnabled( 'image_resizer' ) )
		{
			return URL_PUBLIC . PUBLIC_FILES . '/gallery/' . $this->page_id . '/' . ( $width ? $width : 0 ) . 'x' . ( $height ? $height : 0 ) . '-' . $this->file_name;
		}
		else
			return $this->url();
	}

}

?>
