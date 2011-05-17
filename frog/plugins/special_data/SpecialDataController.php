<?php

class SpecialDataController extends PluginController
{
	public function __construct()
	{
		$this->setLayout('backend');
		$action = array_shift(Dispatcher::getParams());
		
		if( (AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer')) && ($action == 'index' || $action == '') )
			$this->assignToLayout('actions', new View('../../plugins/special_data/views/actions'));
	}
	
	public function index()
	{
		$datas = Record::findAllFrom('SpecialData');
	
		$this->display('special_data/views/index', array(
			'datas' => $datas
		));
	}
	
	public function add()
	{
		$post_data = Flash::get('data');
		
		if( !empty($_POST['data']) )
		{
			$post_data = $_POST['data'];
		
			if( empty($post_data['name']) || empty($post_data['identifier']) || empty($post_data['type']) )
			{
				Flash::set('error', __('Fields can\'t be empty.'));
			}
			else
			{
				$data = new SpecialData();
				$data->setFromData($post_data);
				
				if( $data->save() )
				{
					Flash::set('success', __('New data created.'));
					
					if( isset($_POST['continue']) )
						redirect(get_url('plugin/special_data/edit/' . $data->id));
					else
						redirect(get_url('plugin/special_data'));
				}
				else
				{
					Flash::set('error', __('Can\'t create new data.'));
				}				
			}
			
			redirect(get_url('plugin/special_data/add'));
		}
		
		if( empty($data) )
		{
			$data = array(
				'name' 			=> '',
				'identifier' 	=> '',
				'type' 			=> '',
				'value' 		=> ''
			);
		}
		
		$this->display('special_data/views/edit', array(
			'action' => 'add',
			'data' => (object)$data
		));
	}
	
	public function edit( $data_id )
	{
		if( Plugin::isEnabled('tinymce') )
			Plugin::addJavascript('tinymce', 'tinymce/tiny_mce.js');
	
		if( $data = Record::findByIdFrom('SpecialData', $data_id) )
		{
			if( !empty($_POST['data']) )
			{
				$post_data = $_POST['data'];
			
				if( empty($post_data['name']) || empty($post_data['identifier']) || empty($post_data['value']) )
				{
					Flash::set('error', __('Fields can\'t be empty.'));
				}
				else
				{
					$data->setFromData($post_data);
					
					if( $data->save() )
					{
						Flash::set('success', __('Data saved.'));
						
						if( isset($_POST['continue']) )
							redirect(get_url('plugin/special_data/edit/' . $data->id));
						else
							redirect(get_url('plugin/special_data'));
					}
					else
					{
						Flash::set('error', __('Can\'t save data.'));
					}
					
					redirect(get_url('plugin/special_data/add'));
				}
			}
			
			if( empty($data) )
			{
				$data = array(
					'name' 			=> '',
					'identifier' 	=> '',
					'type' 			=> '',
					'value' 		=> ''
				);
			}
			
			$this->display('special_data/views/edit', array(
				'action' => 'edit',
				'data' => (object)$data
			));
		}
		else
		{
			Flash::set('error', __('Data with this ID do not finded.'));
			redirect(get_url('plugin/special_data'));
		}
	}
	
	public function remove( $data_id )
	{
		if( $data = Record::findByIdFrom('SpecialData', $data_id) )
		{
			if( $data->delete() )
			{
				Flash::set('success', __('Data successfully removed!'));
			}
			else
			{
				Flash::set('error', __('Data not removed!'));
			}
		}
		
		redirect(get_url('plugin/special_data'));
	}
}

?>