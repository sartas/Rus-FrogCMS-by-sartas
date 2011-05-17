<?php if(!defined('DEBUG')) die;


/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2010 Maslakov Alexandr <jmas.ukraine@gmail.com>
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
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package frog
 * @subpackage plugin.comments
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 1.2.0
 * @since Frog version 0.9.3
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, Bebliuc George & Martijn van der Kleijn, 2008
 */

 
class CommentsController extends PluginController
{
	public function __construct()
	{
		$this->setLayout('backend');
	}


	public function index()
	{
		$comments = Comment::find(array('order' => 'comment.is_approved, comment.created_on DESC'));
		
		$this->display('comments/views/index', array(
			'comments' => $comments
		));
	}
	
	
	public function approve( $comment_id )
	{
		if( $comment = Comment::findById($comment_id) )
		{
			$comment->is_approved = Comment::APPROVED;
			
			if( $comment->save() )
			{
				Flash::set('success', __('Comment successfully approved!'));
			}
			else
			{
				Flash::set('error', __('Comment not approved!'));
			}
		}
		
		redirect(get_url('plugin/comments'));
	}
	
	
	public function remove( $comment_id )
	{
		if( $comment = Comment::findById($comment_id) )
		{
			if( $comment->delete() )
			{
				Flash::set('success', __('Comment successfully removed!'));
			}
			else
			{
				Flash::set('error', __('Comment not removed!'));
			}
		}
		
		redirect(get_url('plugin/comments'));
	}
	
	
	public function settings()
	{
		// when post
		if( isset($_POST['comments_settings']) )
		{
			if( Plugin::setAllSettings( $_POST['comments_settings'], 'comments' ) )
			{
				Flash::set('success', __('Comments settings successfully saved!'));
			}
			else
			{
				Flash::set('error', __('Comments settings not saved!'));
			}
			
			redirect(get_url('setting/plugin'));
		}
	
		$this->display('comments/views/settings', array(
			'settings' => Plugin::getAllSettings('comments')
		));
	}
}

?>