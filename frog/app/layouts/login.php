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
 * @subpackage layout
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */
 
 $controller = Dispatcher::getController();
 $action = Dispatcher::getAction();
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo __('Login') .' &ndash; '. Setting::get('admin_title'); ?></title>
		
		<base href="<?php echo rtrim(BASE_URL, '?/').'/'; ?>" />
		
		<link href="stylesheets/login.css" rel="stylesheet" type="text/css" />
		
	<?php if( file_exists(FROG_ROOT .'/'. ADMIN_DIR .'/'. 'themes/'. Setting::get('theme') .'/login.css') ): ?>
		<link href="themes/<?php echo Setting::get('theme'); ?>/login.css" media="screen" rel="stylesheet" type="text/css" />
	<?php endif; ?>
	
		<script src="javascripts/jquery/jquery.js" type="text/javascript"></script>
		
		<script type="text/javascript" charset="utf-8">
			/*
				Messages animation
			*/
			var messageTimer = null;
			var $message = null;
			
			var messageHide = function(){
				$message.animate({ opacity: 0 }, 1000, function(){ jQuery(this).css('z-index', -100); });
			};
			
			var animateMessage_height = null;				
			var animateMessage = function()
			{
				var messageTimer = null;
				var $message = null;
				
				var messageHide = function(){
					$message.animate({ height: 0 }, 500);
				};
				
				$message = jQuery('.frog-message');
				
				if( animateMessage_height == null )
					animateMessage_height = $message.height();
				
				$message
					.css({height: 0})
					.animate({ height: animateMessage_height }, 500, function(){
						messageTimer = setTimeout(messageHide, 2000);
					})
					.mouseover(function(){
						clearTimeout(messageTimer);
					})
					.mouseout(function(){
						messageTimer = setTimeout(messageHide, 1000);
					});
			};
			
			
			
			/*
				When DOM loaded
			*/
			jQuery(function(){				
				/*
					Messages
				*/
				animateMessage();
				
				
				/*
					Focus first field
				*/
				jQuery('#dialog input[type="text"]:first').focus();
			});
		</script>
	</head>
	<body id="body_<?php echo($controller .'_'. $action); ?>">

		<?php if( ($error = Flash::get('error')) !== null ): ?>
		<div id="error" class="frog-message"><?php echo $error; ?></div>
		<?php endif; ?>
		
		<?php if( ($success = Flash::get('success')) !== null ): ?>
		<div id="success" class="frog-message"><?php echo $success; ?></div>
		<?php endif; ?>
		
		<?php echo $content_for_layout; ?>
		
		<p id="website"><?php echo __('Website'); ?>: <a href="<?php echo URL_PUBLIC; ?>"><?php echo URL_PUBLIC; ?></a></p>
		
		<noscript id="noscript">
			<p><?php echo __('JavaScript is switched off or not supported in your Internet Browser. Please switch on JavaScript or change your Browser. Thanks.'); ?></p>
		</noscript>
		<script type="text/javascript">
			/*
				Hide noscript for IE
			*/
			jQuery('#noscript').hide();
		</script>
		
	</body>
</html>