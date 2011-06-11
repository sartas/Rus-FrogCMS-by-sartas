<?php

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
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
 * This file will insert all basic data to database
 */

// Securtiy feature - make sure this is called from the install sequence
if( !defined('INSTALL_SEQUENCE') || !isset($admin_name) || !isset($admin_passwd) )
	die('Attempt to call setup file outside of install sequence!');

function frog_datetime_incrementor()
{
    static $cpt=1;
    $cpt++;
    return date('Y-m-d H:i:s', time()+$cpt);
}


//  Dumping data for table: layout -------------------------------------------

$PDO->exec("INSERT INTO layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id, parts_type, position) VALUES (1, 'none', 'text/html', '<?php echo \$this->content(); ?>', '2011-05-14 16:11:33', '2011-05-14 16:11:34', 1, 1, 'text', NULL)");
$PDO->exec("INSERT INTO layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id, parts_type, position) VALUES (2, 'Normal', 'text/html', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\r\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n  <title><?php echo \$this->title(); ?></title>\r\n\r\n  <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=utf-8\" />\r\n  <meta name=\"robots\" content=\"index, follow\" />\r\n  <meta name=\"description\" content=\"<?php echo (\$this->description() != '''') ? \$this->description() : ''Default description goes here''; ?>\" />\r\n  <meta name=\"keywords\" content=\"<?php echo (\$this->keywords() != '''') ? \$this->keywords() : ''default, keywords, here''; ?>\" />\r\n  <meta name=\"author\" content=\"Author Name\" />\r\n\r\n  <link rel=\"favourites icon\" href=\"<?php echo URL_PUBLIC; ?>favicon.ico\" />\r\n    <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/normal/screen.css\" media=\"screen\" type=\"text/css\" />\r\n    <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/normal/print.css\" media=\"print\" type=\"text/css\" />\r\n    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"Frog Default RSS Feed\" href=\"<?php echo URL_PUBLIC.((USE_MOD_REWRITE)?'''':''/?''); ?>rss.xml\" />\r\n\r\n</head>\r\n<body>\r\n<div id=\"page\">\r\n<?php \$this->includeSnippet(''header''); ?>\r\n<div id=\"content\">\r\n\r\n  <h2><?php echo \$this->title(); ?></h2>\r\n  <?php echo \$this->content(''text_block''); ?> \r\n\r\n</div> <!-- end #content -->\r\n<div id=\"sidebar\">\r\n\r\n\r\n</div> <!-- end #sidebar -->\r\n<?php \$this->includeSnippet(''footer''); echo memory_usage().''||''.execution_time();?>\r\n<? print_r(Benchmark::get( ''total'' ));?>\r\n</div> <!-- end #page -->\r\n</body>\r\n</html>', '2011-05-14 16:11:35', '2011-06-11 01:59:02', 1, 2, 'text', NULL)");
$PDO->exec("INSERT INTO layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id, parts_type, position) VALUES (3, 'RSS XML', 'application/rss+xml', '<?php echo \$this->content(); ?>', '2011-05-14 16:11:37', '2011-05-14 16:11:38', 1, 1, '', NULL)");


//  Dumping data for table: page ---------------------------------------------

$PDO->exec("INSERT INTO page (id, title, slug, breadcrumb, keywords, description, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (1, 'Home Pagerrrrddddddd', '', 'Home Pagerrrrddddddd', '', '', 0, 2, '', 100, '2011-05-23 21:35:39', '2011-05-23 21:35:40', '2011-05-24 23:44:06', 1, 1, 0, 1, 0)");

		


//  Dumping data for table: permission ---------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (1, 'administrator')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (2, 'developer')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (3, 'editor')");


//  Dumping data for table: setting ------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('admin_title', 'Frog CMS')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('language', 'en')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('theme', 'default')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_status_id', '1')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_filter_id', '')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_tab', '')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('allow_html_title', 'off')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('plugins', 'a:5:{s:7:\"textile\";i:1;s:8:\"markdown\";i:1;s:7:\"archive\";i:1;s:14:\"page_not_found\";i:1;s:12:\"file_manager\";i:1;}')");
$PDO->exec("INSERT INTO setting (name, value) VALUES ('translit_slug', 'on')");

//  Dumping data for table: snippet ------------------------------------------

$PDO->exec("INSERT INTO snippet (id, name, filter_id, content, content_html, created_on, updated_on, created_by_id, updated_by_id, position) VALUES (1, 'header', '', '<div id=\"header\">\r\n  <h1><a href=\"<?php echo URL_PUBLIC; ?>\">Frog</a> <span>content management simplified</span></h1>\r\n  <div id=\"nav\">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class=\"current\"'': ''''; ?> href=\"<?php echo URL_PUBLIC; ?>\">Home</a></li>\r\n<?php foreach(\$this->find(''/'')->children() as \$menu): ?>\r\n      <li><?php echo \$menu->link(\$menu->title, (in_array(\$menu->slug, explode(''/'', \$this->url)) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '<div id=\"header\">\r\n  <h1><a href=\"<?php echo URL_PUBLIC; ?>\">Frog</a> <span>content management simplified</span></h1>\r\n  <div id=\"nav\">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class=\"current\"'': ''''; ?> href=\"<?php echo URL_PUBLIC; ?>\">Home</a></li>\r\n<?php foreach(\$this->find(''/'')->children() as \$menu): ?>\r\n      <li><?php echo \$menu->link(\$menu->title, (in_array(\$menu->slug, explode(''/'', \$this->url)) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '2011-05-14 16:12:00', '2011-05-26 23:29:38', 1, 1, NULL)");
$PDO->exec("INSERT INTO snippet (id, name, filter_id, content, content_html, created_on, updated_on, created_by_id, updated_by_id, position) VALUES (2, 'footer', '', '<div id=\"footer\"><div id=\"footer-inner\">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href=\"http://www.madebyfrog.com/\" title=\"Frog\">Madebyfrog.com</a><br />\r\n  Powered by <a href=\"http://www.madebyfrog.com/\" title=\"Frog CMS\">Frog CMS</a>.\r\n  </p>\r\n</div></div><!-- end #footer -->', '<div id=\"footer\"><div id=\"footer-inner\">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href=\"http://www.madebyfrog.com/\" alt=\"Frog\">Madebyfrog.com</a><br />\r\n  Powered by <a href=\"http://www.madebyfrog.com/\" alt=\"Frog\">Frog CMS</a>.\r\n  </p>\r\n</div></div><!-- end #footer -->', '2011-05-14 16:12:02', '2011-05-14 16:12:03', 1, 1, NULL)");


//  Dumping data for table: user ---------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."user (id, name, email, username, password, language, created_on, updated_on, created_by_id, updated_by_id) VALUES (1, 'Administrator', 'admin@yoursite.com', '".$admin_name."', '".$admin_passwd."', 'en', '".frog_datetime_incrementor()."', '".frog_datetime_incrementor()."', 1, 1)");


//  Dumping data for table: user_permission ----------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."user_permission (user_id, permission_id) VALUES (1, 1)");
