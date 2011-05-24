<?php

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
 * @subpackage stylesheets
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */
/*
  DEFINITIONS: Frog path
 */
define( 'FROG_ROOT', dirname( __FILE__ ) );

if ( !defined( 'FROG_BACKEND' ) )
{
	define( 'FROG_BACKEND', false );
}


/*
  INCLUDING: Config
 */
// Including config file
if ( file_exists( FROG_ROOT . '/config.php' ) )
{
	require_once( FROG_ROOT . '/config.php' );
}
else
{
	die( 'Please put "config.php" file at site root!' );
}



/*
  INSTALLING
 */
if ( !defined( 'DEBUG' ) )
{
	header( 'Location: ' . (FROG_BACKEND ? '../' : '') . 'install/' );
	exit();
}



/*
  DEFINITION: Current page URI
 */
$__URI__ = '';

if ( !empty( $_SERVER['QUERY_STRING'] ) )
{
	$__URI__ = $_SERVER['QUERY_STRING'];

	if ( strstr( $__URI__, '&' ) !== false )
		$__URI__ = substr( $__URI__, 0, strpos( $__URI__, '&' ) );
}

if ( URL_SUFFIX != '' && strpos( $__URI__, URL_SUFFIX ) !== false )
{
	$__URI__ = substr( $__URI__, 0, strlen( $__URI__ ) - strlen( URL_SUFFIX ) );
}

define( 'CURRENT_URI', $__URI__ );



/*
  DEFINITION: BASE_URL
 */
if ( FROG_BACKEND )
{
	define( 'BASE_URL', URL_PUBLIC . ( substr( URL_PUBLIC, -1 ) == '/' ? '' : '/' ) . ADMIN_DIR . '/' . ( USE_MOD_REWRITE ? '' : '?/' ) );
}
else
{
	define( 'BASE_URL', URL_PUBLIC . ( substr( URL_PUBLIC, -1 ) == '/' ? '' : '/' ) . ( USE_MOD_REWRITE ? '' : '?/' ) );
}



/*
  DEFINITIONS: Framework constants
 */
// Frog CMS root
define( 'FROG_VERSION', '1.0.7' );

// Frog CMS core root path
define( 'CORE_ROOT', FROG_ROOT . '/frog' );

// Frog CMS framework application path
define( 'APP_PATH', CORE_ROOT . '/app' );

// Framework defines
define( 'SESSION_LIFETIME', 3600 );
define( 'REMEMBER_LOGIN_LIFETIME', 1209600 ); // two weeks

define( 'DEFAULT_CONTROLLER', 'front' );
define( 'DEFAULT_ACTION', 'index' );

define( 'COOKIE_PATH', '/' );
define( 'COOKIE_DOMAIN', '' );
define( 'COOKIE_SECURE', false );



/*
  INCLUDING: Green framework
 */
require_once( CORE_ROOT . '/Framework.php' );



/*
  INITIALIZING: Default defines
 */
if ( !defined( 'HELPER_PATH' ) )
{
	define( 'HELPER_PATH', CORE_ROOT . '/helpers' );
}

if ( !defined( 'URL_SUFFIX' ) )
{
	define( 'URL_SUFFIX', '' );
}

if ( !defined( 'PUBLIC_FILES' ) )
{
	define( 'PUBLIC_FILES', 'public' );
}

if ( !defined( 'PLUGINS' ) )
{
	define( 'PLUGINS', 'plugins' );
}

if ( !defined( 'PLUGINS_URL' ) )
{
	define( 'PLUGINS_URL', URL_PUBLIC . 'frog/' . PLUGINS . '/' );
}


if ( !defined( 'PLUGINS_DIR' ) )
{
	define( 'PLUGINS_DIR', CORE_ROOT . '/' . PLUGINS . '/' );
}

if ( !defined( 'DEFAULT_LOCALE' ) )
{
	define( 'DEFAULT_LOCALE', 'en' );
}



/*
  INITIALIZING: Connecting to Database
 */
if ( USE_PDO && class_exists( 'PDO', false ) )
{
	// adding function date_format to sqlite 3 'mysql date_format function'
	if ( !function_exists( 'mysql_date_format_function' ) )
	{

		function mysql_function_date_format( $date, $format )
		{
			return strftime( $format, strtotime( $date ) );
		}

	}

	try
	{
		$__CONN__ = new PDO( DB_DSN, DB_USER, DB_PASS );
	} catch ( PDOException $error )
	{
		die( 'DB Connection failed: ' . $error->getMessage() );
	}

	switch ( $__CONN__->getAttribute( PDO::ATTR_DRIVER_NAME ) )
	{
		// MySQL settings
		case 'mysql':
			$__CONN__->setAttribute( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );
			break;

		// SQLite3 settings
		case 'sqlite':
			$__CONN__->sqliteCreateFunction( 'date_format', 'mysql_function_date_format', 2 );
			break;
	}
}
else
{
	require_once( CORE_ROOT . '/libraries/DoLite.php' );
	$__CONN__ = new DoLite( DB_DSN, DB_USER, DB_PASS );
}

// Assign DB Connection to Record
Record::connection( $__CONN__ );
Record::getConnection()->exec( 'set names "utf8"' );

// Backward compatibility
//$__FROG_CONN__ = $__CONN__; // Frog CMS 0.95
//$__WOLF_CONN__ = $__CONN__; // Wolf CMS



/*
  INITIALIZING: Class init
 */
Setting::init();

// Get user locale
AuthUser::load();
$__LOCALE__ = ( AuthUser::isLoggedIn() ? AuthUser::getRecord()->language : DEFAULT_LOCALE );

// Set system localization
use_helper( 'I18n' );
I18n::setLocale( $__LOCALE__ );

Plugin::init();
Flash::init();





/*
  RUN Dispatcher
 */
if ( FROG_BACKEND )
{
	$default_tab = Setting::get( 'default_tab' );
	$default_tab = empty( $default_tab ) ? 'page/index' : $default_tab;

	Dispatcher::addRoute( array(
		'/' => $default_tab,
		'/:any' => '$1'
	) );
}
else
{
	Dispatcher::addRoute( array(
		'/:any' => 'front/index/$1'
	) );
}

// Wish me luck...
Dispatcher::dispatch( $__URI__ );

$PDO = Record::getConnection();

/*
  $PDO->exec("CREATE TABLE ".TABLE_PREFIX."page_image (
  id int(11) unsigned NOT NULL auto_increment,
  page_id int(11) unsigned default NULL,
  file_name varchar(255) default NULL,
  alternate varchar(255) default NULL,
  PRIMARY KEY  (id)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
 */
/*
  $PDO->exec("CREATE TABLE ".TABLE_PREFIX."page_text (
  id int(11) unsigned NOT NULL auto_increment,
  name varchar(100) default NULL,
  filter_id varchar(25) default NULL,
  content longtext,
  content_html longtext,
  page_id int(11) unsigned default NULL,
  PRIMARY KEY  (id)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");


  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (1, 'body', '', '<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<?php \$last_article = \$page_article->children(array(''limit'' => 1, ''order'' => ''page.created_on DESC'')); ?>\r\n\r\n<div class=\"first entry\">\r\n  <h3><?php echo \$last_article->link(); ?></h3>\r\n  <?php echo \$last_article->content(); ?>\r\n  <?php if (\$last_article->hasContent(''extended'')) echo \$last_article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$last_article->author(); ?> on <?php echo \$last_article->date(); ?></p>\r\n</div>\r\n\r\n<?php foreach (\$page_article->children(array(''limit'' => 4, ''offset'' => 1, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <?php if (\$article->hasContent(''extended'')) echo \$article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?></p>\r\n</div>\r\n<?php endforeach; ?>\r\n', '<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<?php \$last_article = \$page_article->children(array(''limit'' => 1, ''order'' => ''page.created_on DESC'')); ?>\r\n\r\n<div class=\"first entry\">\r\n  <h3><?php echo \$last_article->link(); ?></h3>\r\n  <?php echo \$last_article->content(); ?>\r\n  <?php if (\$last_article->hasContent(''extended'')) echo \$last_article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$last_article->author(); ?> on <?php echo \$last_article->date(); ?></p>\r\n</div>\r\n\r\n<?php foreach (\$page_article->children(array(''limit'' => 4, ''offset'' => 1, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <?php if (\$article->hasContent(''extended'')) echo \$article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?></p>\r\n</div>\r\n<?php endforeach; ?>\r\n', 1)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (2, 'body', '', '<?php echo ''<?''; ?>xml version=\"1.0\" encoding=\"UTF-8\"<?php echo ''?>''; ?> \r\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\r\n<channel>\r\n	<title>Frog CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href=\"<?php echo BASE_URL ?>/rss.xml\" rel=\"self\" type=\"application/rss\+xml\" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, madebyfrog.com</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Frog CMS</generator>\r\n	<description>The main news feed from Frog CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php \$articles = \$this->find(''articles''); ?>\r\n	<?php foreach (\$articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n	<item>\r\n		<title><?php echo \$article->title(); ?></title>\r\n		<description><?php if (\$article->hasContent(''summary'')) { echo \$article->content(''summary''); } else { echo strip_tags(\$article->content()); } ?></description>\r\n		<pubDate><?php echo \$article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo \$article->url(); ?></link>\r\n		<guid><?php echo \$article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', '<?php echo ''<?''; ?>xml version=\"1.0\" encoding=\"UTF-8\"<?php echo ''?>''; ?> \r\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\r\n<channel>\r\n	<title>Frog CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href=\"<?php echo BASE_URL ?>/rss.xml\" rel=\"self\" type=\"application/rss\+xml\" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, madebyfrog.com</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Frog CMS</generator>\r\n	<description>The main news feed from Frog CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php \$articles = \$this->find(''articles''); ?>\r\n	<?php foreach (\$articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n	<item>\r\n		<title><?php echo \$article->title(); ?></title>\r\n		<description><?php if (\$article->hasContent(''summary'')) { echo \$article->content(''summary''); } else { echo strip_tags(\$article->content()); } ?></description>\r\n		<pubDate><?php echo \$article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo \$article->url(); ?></link>\r\n		<guid><?php echo \$article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', 2)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (3, 'body', 'textile', 'This is my site. I live in this city ... I do some nice things, like this and that ...', '<p>This is my site. I live in this city &#8230; I do some nice things, like this and that &#8230;</p>', 3)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (4, 'body', '', '<?php \$last_articles = \$this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(\$article->title); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', \$article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', '<?php \$last_articles = \$this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(\$article->title); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', \$article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', 4)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (5, 'body', 'markdown', 'My **first** test of my first article that uses *Markdown*.', '<p>My <strong>first</strong> test of my first article that uses <em>Markdown</em>.</p>\n', 5)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (7, 'body', 'markdown', 'This is my second article.', '<p>This is my second article.</p>\n', 6)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (8, 'body', '', '<?php \$archives = \$this->archive->get(); ?>\r\n<?php foreach (\$archives as \$archive): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$archive->link(); ?></h3>\r\n  <p class=\"info\">Posted by <?php echo \$archive->author(); ?> on <?php echo \$archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', '<?php \$archives = \$this->archive->get(); ?>\r\n<?php foreach (\$archives as \$archive): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$archive->link(); ?></h3>\r\n  <p class=\"info\">Posted by <?php echo \$archive->author(); ?> on <?php echo \$archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', 7)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (9, 'sidebar', '', '<h3>About Me</h3>\r\n\r\n<p>I''m just a demonstration of how easy it is to use Frog CMS to power a blog. <a href=\"<?php echo BASE_URL; ?>about_us\">more ...</a></p>\r\n\r\n<h3>Favorite Sites</h3>\r\n<ul>\r\n  <li><a href=\"http://www.madebyfrog.com\">Frog CMS</a></li>\r\n</ul>\r\n\r\n<?php if(url_match(''/'')): ?>\r\n<h3>Recent Entries</h3>\r\n<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<ul>\r\n<?php foreach (\$page_article->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n  <li><?php echo \$article->link(); ?></li> \r\n<?php endforeach; ?>\r\n</ul>\r\n<?php endif; ?>\r\n\r\n<a href=\"<?php echo BASE_URL; ?>articles\">Archives</a>\r\n\r\n<h3>Syndicate</h3>\r\n\r\n<a href=\"<?php echo BASE_URL; ?>rss.xml\">Articles RSS Feed</a>', '<h3>About Me</h3>\r\n\r\n<p>I''m just a demonstration of how easy it is to use Frog CMS to power a blog. <a href=\"<?php echo BASE_URL; ?>about_us\">more ...</a></p>\r\n\r\n<h3>Favorite Sites</h3>\r\n<ul>\r\n  <li><a href=\"http://www.madebyfrog.com\">Frog CMS</a></li>\r\n</ul>\r\n\r\n<?php if(url_match(''/'')): ?>\r\n<h3>Recent Entries</h3>\r\n<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<ul>\r\n<?php foreach (\$page_article->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n  <li><?php echo \$article->link(); ?></li> \r\n<?php endforeach; ?>\r\n</ul>\r\n<?php endif; ?>\r\n\r\n<a href=\"<?php echo BASE_URL; ?>articles\">Archives</a>\r\n\r\n<h3>Syndicate</h3>\r\n\r\n<a href=\"<?php echo BASE_URL; ?>rss.xml\">Articles RSS Feed</a>', 1)");
  $PDO->exec("INSERT INTO ".TABLE_PREFIX."page_text (id, name, filter_id, content, content_html, page_id) VALUES (10, 'sidebar', '', '<?php \$article = \$this->find(''articles''); ?>\r\n<?php \$archives = \$article->archive->archivesByMonth(); ?>\r\n\r\n<h3>Archives By Month</h3>\r\n<ul>\r\n<?php foreach (\$archives as \$date): ?>\r\n  <li><a href=\"<?php echo BASE_URL . \$this->url .''/''. \$date . URL_SUFFIX; ?>\"><?php echo strftime(''%B %Y'', strtotime(strtr(\$date, ''/'', ''-''))); ?></a></li>\r\n<?php endforeach; ?>\r\n</ul>', '<?php \$article = \$this->find(''articles''); ?>\r\n<?php \$archives = \$article->archive->archivesByMonth(); ?>\r\n\r\n<h3>Archives By Month</h3>\r\n<ul>\r\n<?php foreach (\$archives as \$date): ?>\r\n  <li><a href=\"<?php echo BASE_URL . \$this->url .''/''. \$date . URL_SUFFIX; ?>\"><?php echo strftime(''%B %Y'', strtotime(strtr(\$date, ''/'', ''-''))); ?></a></li>\r\n<?php endforeach; ?>\r\n</ul>', 4)");
 */

//	$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD parts varchar(255) default NULL");
//echo I18n::translit("фффффф");

//$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('translit_slug', 'on')");

?>