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

 
 
/*
	Autoload
*/
AutoLoader::addFile('Comment', CORE_ROOT . '/plugins/comments/Comment.php');



if( FROG_BACKEND ) /* BACKEND */
{

	// Comemnts count for Tab
	$comments_unapproved_count = Comment::countFrom('Comment', "is_approved = '". Comment::UNAPPROVED ."'");
	$comments_count = Comment::countFrom('Comment');
	
	// Add controller and Comments Tab
	Plugin::addController('comments');
	Plugin::addTab('Content', __('Comments'). ' ('. $comments_unapproved_count .'/'. $comments_count .')', 'plugin/comments', 'administrator,developer,editor');
	
	// Handler for page edit form
	function comments_display_dropdown( $page )
	{
	    echo('
			<p id="page_edit_comments">
				<label for="page_comment_status">'. __('Comments') .'</label>
				<select id="page_comment_status" class="input-select" name="page[comment_status]">
				    <option value="'. Comment::CLOSED .'" '. ($page->comment_status == Comment::CLOSED ? 'selected="selected"': '').' >'. __('Closed') .'</option>
				    <option value="'. Comment::OPENED .'" '. ($page->comment_status == Comment::OPENED ? 'selected="selected"': '').' >'. __('Opened') .'</option>
			    </select>
			</p>
		');
	}
	
	// Observe event
	Observer::observe('view_page_edit_plugins', 'comments_display_dropdown');
	
}
else /* FRONTEND */
{

	/*
		Process post request handler
	*/
	function comments_process_post( $page )
	{
		$settings = Plugin::getAllSettings('comments');
		
		// When we know that comments form posted
		if( isset($_POST['comment']) )
		{
			$post = $_POST['comment'];
			
			Flash::set('comments_form', $post);
			
			if( empty($post['author_name']) || empty($post['author_email']) || empty($post['body']) )
			{
				Flash::set( 'comments_error', __('Required fields do not filled properly!') );
			}
			elseif( ! preg_match('/[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+/i', $post['author_email']) )
			{
				Flash::set( 'comments_error', __('Please, enter valid e-mail address!') );
			}
			elseif( Plugin::isEnabled('captcha') && $settings['use_captcha'] == 'yes' && captcha_check( $_POST['captcha'] ) === false )
			{
				Flash::set( 'comments_error', __('Captcha image have different text. Please retype captcha!') );
			}
			else
			{
				# Clean all post data
				if( strstr($post['author_link'], 'http://') === false )
					$post['author_link'] = 'http://' . $post['author_link'];
			
				// If it is not link in author_link field - we killd it
				if( ! preg_match("~^(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(:[0-9]{1,5})?(?:/[ížºí¾¿a-z0-9.,_@%\(\)\*&?+=\~/-]*)?(?:#[^ '\"&<>]*)?$~i", $post['author_link']) )
					unset($post['author_link']);
				
				$allowed_tags = array(
			        'a' => array(
			            'href' => array(),
			            'title' => array()
			        ),
			        'abbr' => array(
			            'title' => array()
			        ),
			        'acronym' => array(
			            'title' => array()
			        ),
			        'b' => array(),
			        'blockquote' => array(
			            'cite' => array()
			        ),
			        'br' => array(),
			        'code' => array(),
			        'em' => array(),
			        'i' => array(),
			        'p' => array(),
			        'strike' => array(),
			        'strong' => array()
			    );
				
				use_helper('Kses');
				
				$post['author_name'] = kses( trim($post['author_name']), array() );
				$post['body'] = preg_replace('/^(.*?)$/m', '<p>\1</p>', preg_replace('/[\f\r\n]+/', "\n", preg_replace('/ +/', ' ', kses( trim($post['body']), $allowed_tags )) ));
				
				
				
				
				# Create new comment
				$comment = new Comment();
				$comment->setFromData( $post );
				$comment->ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
				$comment->created_on = date('Y-m-d H:i:s');
				$comment->page_id = $page->id;
				$comment->is_approved = ( $settings['auto_approve'] == 'yes' ? Comment::APPROVED : Comment::UNAPPROVED );
				
				if( $comment->save() )
				{
					Flash::set( 'comments_success', ($settings['auto_approve'] == 'yes' ? __('Comment posted successfully!') : __('Comment sent to moderation...')) );
					
					unset( $post['body'] );
					
					Flash::set('comments_form', $post);
				}
				else
				{
					Flash::set( 'comments_error', __('We can\'t post form data!') );
				}
			}
			
			redirect( $page->url() );
		}
	}
	
	// Observe comment_process_post
	Observer::observe('page_found', 'comments_process_post');


	
	/*
		Display comments form page
	*/
	function comments_display_form( $page )
	{
		$error = false;
		$success = false;
		
		$settings = Plugin::getAllSettings('comments');
		$post = Flash::get('comments_form');
		
		$form = new stdClass;
		$form->author_name  = isset($post['author_name'])  ? $post['author_name'] : '';
		$form->author_email = isset($post['author_email']) ? $post['author_email'] : '';
		$form->author_link  = isset($post['author_link'])  ? $post['author_link'] : '';
		$form->body         = isset($post['body'])         ? $post['body'] : '';
		
		
		// Render view
		echo new View('../../plugins/comments/views/front_form', array(
			'error'   => Flash::get('comments_error'),
			'success' => Flash::get('comments_success'),
			'use_captcha' => ($settings['use_captcha'] == 'yes'),
			'page'    => $page,
			'form'    => $form
		));
	}
	
	
	
	/*
		Display all comments of page
	*/
	function comments_display( $page )
	{
		$comments = Comment::find(array('where' => "comment.page_id = '{$page->id}' AND comment.is_approved = '". Comment::APPROVED ."'", 'order' => 'comment.created_on ASC'));
		
		echo new View('../../plugins/comments/views/front_display', array(
			'comments' => $comments
		));
	}
	
	
	
	/*
		Check comments status for page
	*/
	function comments_is_opened( $page )
	{
		return ($page->comment_status == Comment::OPENED);
	}
	
	
	/*
		Get comments count for page
	*/
	function comments_count( $page )
	{
		return Comment::countFrom('Comment', "page_id = {$page->id} AND is_approved = '". Comment::APPROVED ."'");
	}
	
} // end if

?>