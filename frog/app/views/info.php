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
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		
		<title><?php echo __('Information'); ?></title>
		
		<style type="text/css">
			body {
				font-size: 95%;
				font-family: 'Liberation Sans', Helvetica, Arial, sans-serif;
				padding:10% 20% 0 20%;
				color:#000;
			}
			
			a {
				color:blue;
			}
			
			a:hover {
				color:red;
			}
			
			#message {
				background:#fff;
				border-radius:15px;
				-webkit-border-radius:15px;
				-moz-border-radius:15px;
				padding:15px 35px;
				box-shadow:0 1px 2px #000;
				-webkit-box-shadow:0 1px 2px #000;
				-moz-box-shadow:0 1px 2px #000;
			}
			
			#message h1 {
				margin:15px 0;
			}
			
			#status_401 {
				background:maroon;
			}
			
			#status_404 {
				background:yellow;
			}
		</style>
		
	</head>
	<body <?php if($http_status) echo('id="status_'. $http_status .'"'); ?>>
	
		<div id="message">
			<?php echo $message; ?>
		</div>
	
	</body>
</html>