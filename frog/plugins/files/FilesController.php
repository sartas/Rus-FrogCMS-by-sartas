<?php if(!defined('DEBUG')) die;

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Maslakov Alexander <jmas.ukraine@gmail.com>
 *
 * This file is part of Frog CMS.
 *
 * Frog CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Frog CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Frog CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Frog CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package frog
 * @subpackage files
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */

class FilesController extends PluginController
{
	public function __construct()
	{
		if( get_request_method() != 'AJAX' )
			$this->setLayout('backend');
		
		use_helper('Dir');
	}
	

	
	public function index()
	{
        //$this->assignToLayout('actions', new View('../../plugins/files/views/actions'));
		
		$public_dir = realpath(FROG_ROOT .'/'. PUBLIC_FILES);
		
		$this->display('files/views/index', array(
			//'root' => $this->_readDir( $public_dir ),
			'content_children' => new View('../../plugins/files/views/children', array(
				'folder' => $this->_getDir( $public_dir ),
				'level'  => 1
			))
		));
	}
	
	
	
	public function browse()
	{
		if( isset($_POST['level']) && isset($_POST['path']) )
		{
			$path = realpath(FROG_ROOT .'/'. str_replace('..', '', $_POST['path']));
			$level = (int)$_POST['level'];
			
			echo new View('../../plugins/files/views/children', array(
				'folder' => $this->_getDir( $path ),
				'level'  => $level
			));
		}
	}
	
	
	
	private function _getDir( $dir_path )
	{
		if( is_dir( $dir_path ) )
			return new Dir( $dir_path );
		else
			throw new Exception('Wrong dir path!');
	}
	
	
	
	public function edit()
	{
		$args = func_get_args();
		$file_name = str_replace('..', '.', ('/'. join('/', $args)));
		$file_path = realpath( FROG_ROOT .'/'. $file_name );
		
		if( isset($_POST['file']) )
		{
			$this->_edit( $file_name );
		}
		
		if( is_file($file_path) )
		{
			Observer::notify('plugin_files_edit_file', $file_path, $this);
			
			$file = new stdClass;
			$file->name = $file_name;
			$file->content_type = mime_content_type( $file_path );
			$file->content = file_get_contents( $file_path );
			
			$this->display('files/views/edit', array(
				'action' => 'edit',
				'file' => $file
			));
		}
		else
		{
			Flash::set('error', __('File not exists!'));
			redirect(get_url('plugin/files'));
		}
	}
	
	
	
	private function _edit( $file_name )
	{
		$file_path = realpath( FROG_ROOT .'/'. $file_name );
		
		if( file_put_contents( $file_path, $_POST['file']['content'] ) )
		{
			Flash::set('success', __('File saved successfully!'));
		}
		else
		{
			Flash::set('error', __('Can\'t save file!'));
		}
		
		if( isset($_POST['commit']) )
			redirect(get_url('plugin/files'));
		else
			redirect(get_url('plugin/files/edit' . $file_name));
	}
	
	
	
	public function delete()
	{
		$args = func_get_args();
		$file_name = str_replace('..', '.', ('/'. join('/', $args)));
		$file_path = realpath( FROG_ROOT .'/'. $file_name );
			
		if( get_request_method() == 'AJAX' )
		{
			if( $this->_delete( $file_path ) )
				echo 'true';
			else
				echo 'false';
		}
		else
		{		
			if( $this->_delete( $file_path ) )
				Flash::set('success', __('Deleted successfully!'));
			else
				Flash::set('error', __('Not deleted! Check permissions!') );
			
			redirect(get_url('plugin/files'));
		}
	}
	
	
	
	private function _delete( $path )
	{
		if( is_dir( $path ) )
		{
			$dir = new Dir( $path );
			return $dir->remove();
		}
		else
		{
			$file = new DirFile( $path );
			return $file->remove();
		}
	}
	
	
	
	public function upload()
	{
		$args = func_get_args();
		$dir_name = str_replace('..', '.', ('/'. join('/', $args)));
		$dir_path = realpath( FROG_ROOT .'/'. $dir_name );
		
		if( !empty($_FILES['Filedata']) )
		{
			$this->_upload( $_FILES['Filedata']['name'], $_FILES['Filedata']['tmp_name'], $dir_path );
			
			Flash::set('success', __('Files are uploaded!'));
			echo 'true';
		}
		elseif( !empty($_FILES['file_upload']) )
		{
			for( $i=0; $i<count($_FILES['file_upload']['tmp_name']); $i++ )
			{
				$this->_upload( $_FILES['file_upload']['name'][$i], $_FILES['file_upload']['tmp_name'][$i], $dir_path );
			}
			
			Flash::set('success', __('Files are uploaded!'));
			redirect(get_url('plugin/files/'));
		}
		else
		{
			$this->display('files/views/upload', array(
				'dir' => $dir_name
			));
		}
	}
	
	
	
	public function upload_dialog()
	{
		$args = func_get_args();
		$dir_name = str_replace('..', '.', ('/'. join('/', $args)));
		$dir_path = realpath( FROG_ROOT .'/'. $dir_name );
		
		if( !empty($_FILES['Filedata']) )
		{
			$this->_upload( $_FILES['Filedata']['name'], $_FILES['Filedata']['tmp_name'], $dir_path );
			
			echo 'true';
		}
		elseif( !empty($_FILES['file_upload']) )
		{
			for( $i=0; $i<count($_FILES['file_upload']['tmp_name']); $i++ )
			{
				$this->_upload( $_FILES['file_upload']['name'][$i], $_FILES['file_upload']['tmp_name'][$i], $dir_path );
			}
			
			echo 'true';
		}
		else
		{
			$this->display('files/views/upload_dialog', array(
				'dir' => $dir_name
			));
		}
	}
	
	
	
	public function perms_dialog()
	{
		$args = func_get_args();
		$name = str_replace('..', '.', ('/'. join('/', $args)));
		$path = FROG_ROOT .'/'. $name;

		if( is_dir($path) )
		{
			$target = new Dir($path);
		}
		else
		{
			$target = new DirFile($path);
		}
	
		echo new View('../../plugins/files/views/perms_dialog', array(
			'perms'  => $target->getPermsShort(),
			'target' => $target->getPathShort()
		));
	}
	
	
	
	public function perms_change()
	{
		if( isset($_POST['target']) && isset($_POST['perms']) )
		{
			$name = str_replace('..', '.', $_POST['target']);
			$target = FROG_ROOT .'/'. $name;
			
			$perms = preg_replace('/[^0-9]/i', '', $_POST['perms']);
		
			echo( chmod($target, octdec($perms)) ? 'true' : 'false' );
		}
		else
		{
			echo('false');
		}
	}
	
	
	
	public function files_dialog()
	{
		$public_dir = realpath(FROG_ROOT .'/'. PUBLIC_FILES);
	
		echo new View('../../plugins/files/views/files_dialog', array(
			'content_children' => new View('../../plugins/files/views/files_dialog_children', array(
				'folder' => $this->_getDir( $public_dir ),
				'level'  => 1
			))
		));
	}
	
	
	
	public function dialog_dirs()
	{
		if( isset($_POST['level']) && isset($_POST['path']) )
		{
			$path = realpath(FROG_ROOT .'/'. str_replace('..', '', $_POST['path']));
			$level = (int)$_POST['level'];
			
			echo new View('../../plugins/files/views/files_dialog_children', array(
				'folder' => $this->_getDir( $path ),
				'level'  => $level
			));
		}
		else
		{
			echo('false');
		}
	}
	
	
	
	public function dialog_preview()
	{
		$args = func_get_args();
		$name = str_replace('..', '.', ('/'. join('/', $args)));
		
		if( $path = realpath( FROG_ROOT .'/'. $name ) )
		{
			echo new View('../../plugins/files/views/files_dialog_preview', array(
				'dir' => $this->_getDir( $path )
			));
		}
		else
		{
			echo('false');
		}
	}
	
	
	
	private function _upload( $file_name, $temp_name, $dir )
	{
		return move_uploaded_file($temp_name, $dir . '/' . $file_name);
	}
}

?>