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
	Get connection
*/
$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));



/*
	Table structure for table: comment
*/
if( $driver == 'mysql' )
{
	$PDO->exec("CREATE TABLE ".TABLE_PREFIX."comment (
	  id int(11) unsigned NOT NULL auto_increment,
	  page_id int(11) unsigned NOT NULL default '0',
	  body text,
	  author_name varchar(50) default NULL,
	  author_email varchar(100) default NULL,
	  author_link varchar(100) default NULL,
	  is_approved tinyint(1) unsigned NOT NULL default '1',
	  created_on datetime default NULL,
	  PRIMARY KEY  (id),
	  KEY page_id (page_id),
	  KEY created_on (created_on)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	
	$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD comment_status tinyint(1) NOT NULL default '0' AFTER status_id");
    $PDO->exec("ALTER TABLE ".TABLE_PREFIX."comment ADD ip char(100) NOT NULL default '0' AFTER author_link");
}
elseif( $driver == 'sqlite')
{
	$PDO->exec("CREATE TABLE comment (
	    id INTEGER NOT NULL PRIMARY KEY,
	    page_id int(11) NOT NULL default '0',
	    body text ,
	    author_name varchar(50) default NULL ,
	    author_email varchar(100) default NULL ,
	    author_link varchar(100) default NULL , 
	    is_approved tinyint(1) NOT NULL default '1' , 
	    created_on datetime default NULL
	)");
	
	$PDO->exec("CREATE INDEX comment_page_id ON comment (page_id)");
	$PDO->exec("CREATE INDEX comment_created_on ON comment (created_on)");
    
    $PDO->exec("ALTER TABLE page ADD comment_status tinyint(1) NOT NULL default '0'");
    $PDO->exec("ALTER TABLE comment ADD ip char(100) NOT NULL default '0'");	
}



/*
	Insert comments snippet
*/
$PDO->exec("INSERT INTO ".TABLE_PREFIX."snippet(name, filter_id, content, content_html, created_on, updated_on, created_by_id, updated_by_id, position) VALUES ('comments', '', '<?php if(Plugin::isEnabled(''comments'')): ?>\r\n    <?php if(comments_is_opened( \$this )): ?>\r\n            \r\n        <h3>Comments (<?php echo comments_count( \$this ); ?>)</h3>\r\n        <?php comments_display( \$this ); ?>\r\n            \r\n        <h3>Add comment</h3>\r\n        <?php comments_display_form( \$this ); ?>\r\n            \r\n    <?php endif; ?>\r\n<?php endif; ?>', '<?php if(Plugin::isEnabled(''comments'')): ?>\r\n    <?php if(comments_is_opened( \$this )): ?>\r\n            \r\n        <h3>Comments (<?php echo comments_count( \$this ); ?>)</h3>\r\n        <?php comments_display( \$this ); ?>\r\n            \r\n        <h3>Add comment</h3>\r\n        <?php comments_display_form( \$this ); ?>\r\n            \r\n    <?php endif; ?>\r\n<?php endif; ?>', NOW(), NULL, NULL, NULL, NULL)");


/*
	Store settings
*/
$settings = array(
	'auto_approve' => 'no',
	'use_captcha' => 'yes',
	'rowspage' => '15',
	'numlabel' => '1'
);

Plugin::setAllSettings( $settings, 'comments' );