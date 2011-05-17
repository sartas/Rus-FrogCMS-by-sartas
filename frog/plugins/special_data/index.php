<?php

AutoLoader::addFile('SpecialData', CORE_ROOT . '/plugins/special_data/SpecialData.php');

if( FROG_BACKEND )
{
	Plugin::addController('special_data');

	Plugin::addTab('Content', __('Special data'), 'plugin/special_data', 'administrator,developer,editor');
}
else
{
	function special_data( $identifier )
	{
		$identifier = preg_replace('/[^a-z\-\_0-9]/i', '', $identifier);
		
		if( $data = Record::findOneFrom('SpecialData', "identifier='{$identifier}'") )
		{
			return $data->value;
		}
		else
		{
			return false;
		}
	}
}

?>