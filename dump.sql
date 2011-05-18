-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2011 at 01:52 AM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ss`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL DEFAULT '0',
  `body` text,
  `author_name` varchar(50) DEFAULT NULL,
  `author_email` varchar(100) DEFAULT NULL,
  `author_link` varchar(100) DEFAULT NULL,
  `ip` char(100) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `created_on` (`created_on`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

DROP TABLE IF EXISTS `layout`;
CREATE TABLE `layout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `content_type` varchar(80) DEFAULT NULL,
  `content` text,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `updated_by_id` int(11) DEFAULT NULL,
  `parts_type` text,
  `position` mediumint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `name`, `content_type`, `content`, `created_on`, `updated_on`, `created_by_id`, `updated_by_id`, `parts_type`, `position`) VALUES
(1, 'none', 'text/html', '<?php echo $this->content(); ?>', '2011-05-14 16:11:33', '2011-05-14 16:11:34', 1, 1, 'text', NULL),
(2, 'Normal', 'text/html', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"\r\n"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n  <title><?php echo $this->title(); ?></title>\r\n\r\n  <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />\r\n  <meta name="robots" content="index, follow" />\r\n  <meta name="description" content="<?php echo ($this->description() != '''') ? $this->description() : ''Default description goes here''; ?>" />\r\n  <meta name="keywords" content="<?php echo ($this->keywords() != '''') ? $this->keywords() : ''default, keywords, here''; ?>" />\r\n  <meta name="author" content="Author Name" />\r\n\r\n  <link rel="favourites icon" href="<?php echo URL_PUBLIC; ?>favicon.ico" />\r\n    <link rel="stylesheet" href="<?php echo URL_PUBLIC; ?>public/themes/normal/screen.css" media="screen" type="text/css" />\r\n    <link rel="stylesheet" href="<?php echo URL_PUBLIC; ?>public/themes/normal/print.css" media="print" type="text/css" />\r\n    <link rel="alternate" type="application/rss+xml" title="Frog Default RSS Feed" href="<?php echo URL_PUBLIC.((USE_MOD_REWRITE)?'''':''/?''); ?>rss.xml" />\r\n\r\n</head>\r\n<body>\r\n<div id="page">\r\n<?php $this->includeSnippet(''header''); ?>\r\n<div id="content">\r\n\r\n  <h2><?php echo $this->title(); ?></h2>\r\n  <?php echo $this->content(); ?> \r\n  <?php if ($this->hasContent(''extended'')) echo $this->content(''extended''); ?> \r\n\r\n</div> <!-- end #content -->\r\n<div id="sidebar">\r\n\r\n  <?php echo $this->content(''sidebar'', true); ?> \r\n\r\n</div> <!-- end #sidebar -->\r\n<?php $this->includeSnippet(''footer''); ?>\r\n</div> <!-- end #page -->\r\n</body>\r\n</html>', '2011-05-14 16:11:35', '2011-05-14 16:11:36', 1, 1, 'text', NULL),
(3, 'RSS XML', 'application/rss+xml', '<?php echo $this->content(); ?>', '2011-05-14 16:11:37', '2011-05-14 16:11:38', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `layout_part`
--

DROP TABLE IF EXISTS `layout_part`;
CREATE TABLE `layout_part` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) unsigned NOT NULL,
  `type` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `layout_part`
--

INSERT INTO `layout_part` (`id`, `layout_id`, `type`, `name`, `title`) VALUES
(1, 2, 'text', 'text_val', 'Супертекст'),
(20, 2, 'text', 'block', 'Второй текстовой блок');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `breadcrumb` varchar(160) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `layout_id` int(11) unsigned DEFAULT NULL,
  `behavior_id` varchar(25) NOT NULL,
  `status_id` int(11) unsigned NOT NULL DEFAULT '100',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `published_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `updated_by_id` int(11) DEFAULT NULL,
  `position` mediumint(6) unsigned DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `needs_login` tinyint(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `title`, `slug`, `breadcrumb`, `keywords`, `description`, `parent_id`, `layout_id`, `behavior_id`, `status_id`, `comment_status`, `created_on`, `published_on`, `updated_on`, `created_by_id`, `updated_by_id`, `position`, `is_protected`, `needs_login`) VALUES
(1, 'Home Page', '', 'Home Page', '', '', 0, 2, '', 100, 0, '2011-05-14 16:11:39', '2011-05-14 16:11:40', '2011-05-15 01:19:54', 1, 1, 0, 1, 0),
(4, 'Articles', 'articles', 'Articles', NULL, NULL, 1, 0, 'archive', 100, 0, '2011-05-14 16:11:48', '2011-05-14 16:11:49', '2011-05-14 16:11:50', 1, 1, 1, 1, 2),
(5, 'My first article', 'my_first_article', 'My first article', NULL, NULL, 4, 0, '', 100, 0, '2011-05-14 16:11:51', '2011-05-14 16:11:52', '2011-05-14 16:11:53', 1, 1, 0, 0, 2),
(6, 'My second article', 'my_second_article', 'My second article', NULL, NULL, 4, 0, '', 100, 0, '2011-05-14 16:11:54', '2011-05-14 16:11:55', '2011-05-14 16:11:56', 1, 1, 0, 0, 2),
(7, '%B %Y archive', 'monthly_archive', '%B %Y archive', NULL, NULL, 4, 0, 'archive_month_index', 101, 0, '2011-05-14 16:11:57', '2011-05-14 16:11:58', '2011-05-14 16:11:59', 1, 1, 0, 1, 2),
(20, 'k1', 'k1', 'k1', '', '', 1, 2, '', 1, 0, '2011-05-19 01:00:47', NULL, '2011-05-19 01:00:47', 1, 1, NULL, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `page_image`
--

DROP TABLE IF EXISTS `page_image`;
CREATE TABLE `page_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `alternate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `page_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `page_tag`
--

DROP TABLE IF EXISTS `page_tag`;
CREATE TABLE `page_tag` (
  `page_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `page_id` (`page_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `part_text`
--

DROP TABLE IF EXISTS `part_text`;
CREATE TABLE `part_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filter_id` varchar(25) DEFAULT NULL,
  `content` longtext,
  `content_html` longtext,
  `part_id` int(11) unsigned DEFAULT NULL,
  `page_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `part_text`
--

INSERT INTO `part_text` (`id`, `filter_id`, `content`, `content_html`, `part_id`, `page_id`) VALUES
(1, '', '111gffc', '111gffc', 8, 0),
(2, '', '<?php echo ''<?''; ?>xml version="1.0" encoding="UTF-8"<?php echo ''?>''; ?> \r\n<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">\r\n<channel>\r\n	<title>Frog CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href="<?php echo BASE_URL ?>/rss.xml" rel="self" type="application/rss+xml" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, madebyfrog.com</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Frog CMS</generator>\r\n	<description>The main news feed from Frog CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php $articles = $this->find(''articles''); ?>\r\n	<?php foreach ($articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as $article): ?>\r\n	<item>\r\n		<title><?php echo $article->title(); ?></title>\r\n		<description><?php if ($article->hasContent(''summary'')) { echo $article->content(''summary''); } else { echo strip_tags($article->content()); } ?></description>\r\n		<pubDate><?php echo $article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo $article->url(); ?></link>\r\n		<guid><?php echo $article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', '<?php echo ''<?''; ?>xml version="1.0" encoding="UTF-8"<?php echo ''?>''; ?> \r\n<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">\r\n<channel>\r\n	<title>Frog CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href="<?php echo BASE_URL ?>/rss.xml" rel="self" type="application/rss+xml" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, madebyfrog.com</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Frog CMS</generator>\r\n	<description>The main news feed from Frog CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php $articles = $this->find(''articles''); ?>\r\n	<?php foreach ($articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as $article): ?>\r\n	<item>\r\n		<title><?php echo $article->title(); ?></title>\r\n		<description><?php if ($article->hasContent(''summary'')) { echo $article->content(''summary''); } else { echo strip_tags($article->content()); } ?></description>\r\n		<pubDate><?php echo $article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo $article->url(); ?></link>\r\n		<guid><?php echo $article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', 2, 0),
(4, '', '<?php $last_articles = $this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach ($last_articles as $article): ?>\r\n<div class="entry">\r\n  <h3><?php echo $article->link($article->title); ?></h3>\r\n  <?php echo $article->content(); ?>\r\n  <p class="info">Posted by <?php echo $article->author(); ?> on <?php echo $article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', $article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', '<?php $last_articles = $this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach ($last_articles as $article): ?>\r\n<div class="entry">\r\n  <h3><?php echo $article->link($article->title); ?></h3>\r\n  <?php echo $article->content(); ?>\r\n  <p class="info">Posted by <?php echo $article->author(); ?> on <?php echo $article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', $article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', 4, 0),
(5, 'markdown', 'My **first** test of my first article that uses *Markdown*.', '<p>My <strong>first</strong> test of my first article that uses <em>Markdown</em>.</p>\n', 5, 0),
(7, 'markdown', 'This is my second article.', '<p>This is my second article.</p>\r\n', 8, 0),
(8, '', '<?php $archives = $this->archive->get(); ?>\r\n<?php foreach ($archives as $archive): ?>\r\n<div class="entry">\r\n  <h3><?php echo $archive->link(); ?></h3>\r\n  <p class="info">Posted by <?php echo $archive->author(); ?> on <?php echo $archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', '<?php $archives = $this->archive->get(); ?>\r\n<?php foreach ($archives as $archive): ?>\r\n<div class="entry">\r\n  <h3><?php echo $archive->link(); ?></h3>\r\n  <p class="info">Posted by <?php echo $archive->author(); ?> on <?php echo $archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', 7, 0),
(11, '', 't', 't', 0, NULL),
(12, '', 'y', 'y', 0, NULL),
(13, '', 'i', 'i', 0, 18),
(14, '', 'o', 'o', 0, 18),
(20, '', 'k3', 'k3', 20, 21),
(19, '', 'k2', 'k2', 1, 21),
(18, '', 'k3', 'k3', 18, 20);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`) VALUES
(1, 'administrator'),
(2, 'developer'),
(3, 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `plugin_settings`
--

DROP TABLE IF EXISTS `plugin_settings`;
CREATE TABLE `plugin_settings` (
  `plugin_id` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` varchar(255) NOT NULL,
  UNIQUE KEY `plugin_setting_id` (`plugin_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plugin_settings`
--

INSERT INTO `plugin_settings` (`plugin_id`, `name`, `value`) VALUES
('comments', 'auto_approve', 'no'),
('comments', 'use_captcha', 'no'),
('comments', 'rowspage', '15'),
('comments', 'numlabel', '1');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `name` varchar(40) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `id` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `value`) VALUES
('admin_title', 'Frog CMS'),
('language', 'en'),
('theme', 'default'),
('default_status_id', '1'),
('default_filter_id', ''),
('default_tab', ''),
('allow_html_title', 'off'),
('plugins', 'a:9:{s:7:"textile";i:1;s:8:"markdown";i:1;s:7:"archive";i:1;s:14:"page_not_found";i:1;s:12:"file_manager";i:1;s:8:"comments";i:1;s:8:"markitup";i:1;s:12:"rus_translit";i:1;s:9:"part_text";i:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `snippet`
--

DROP TABLE IF EXISTS `snippet`;
CREATE TABLE `snippet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `filter_id` varchar(25) DEFAULT NULL,
  `content` text,
  `content_html` text,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `updated_by_id` int(11) DEFAULT NULL,
  `position` mediumint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `snippet`
--

INSERT INTO `snippet` (`id`, `name`, `filter_id`, `content`, `content_html`, `created_on`, `updated_on`, `created_by_id`, `updated_by_id`, `position`) VALUES
(1, 'header', '', '<div id="header">\r\n  <h1><a href="<?php echo URL_PUBLIC; ?>">Frog</a> <span>content management simplified</span></h1>\r\n  <div id="nav">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class="current"'': ''''; ?> href="<?php echo URL_PUBLIC; ?>">Home</a></li>\r\n<?php foreach($this->find(''/'')->children() as $menu): ?>\r\n      <li><?php echo $menu->link($menu->title, (in_array($menu->slug, explode(''/'', $this->url)) ? '' class="current"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '<div id="header">\r\n  <h1><a href="<?php echo URL_PUBLIC; ?>">Frog</a> <span>content management simplified</span></h1>\r\n  <div id="nav">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class="current"'': ''''; ?> href="<?php echo URL_PUBLIC; ?>">Home</a></li>\r\n<?php foreach($this->find(''/'')->children() as $menu): ?>\r\n      <li><?php echo $menu->link($menu->title, (in_array($menu->slug, explode(''/'', $this->url)) ? '' class="current"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '2011-05-14 16:12:00', '2011-05-14 16:12:01', 1, 1, NULL),
(2, 'footer', '', '<div id="footer"><div id="footer-inner">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href="http://www.madebyfrog.com/" title="Frog">Madebyfrog.com</a><br />\r\n  Powered by <a href="http://www.madebyfrog.com/" title="Frog CMS">Frog CMS</a>.\r\n  </p>\r\n</div></div><!-- end #footer -->', '<div id="footer"><div id="footer-inner">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href="http://www.madebyfrog.com/" alt="Frog">Madebyfrog.com</a><br />\r\n  Powered by <a href="http://www.madebyfrog.com/" alt="Frog">Frog CMS</a>.\r\n  </p>\r\n</div></div><!-- end #footer -->', '2011-05-14 16:12:02', '2011-05-14 16:12:03', 1, 1, NULL),
(3, 'comments', '', '<?php if(Plugin::isEnabled(''comments'')): ?>\r\n    <?php if(comments_is_opened( $this )): ?>\r\n            \r\n        <h3>Comments (<?php echo comments_count( $this ); ?>)</h3>\r\n        <?php comments_display( $this ); ?>\r\n            \r\n        <h3>Add comment</h3>\r\n        <?php comments_display_form( $this ); ?>\r\n            \r\n    <?php endif; ?>\r\n<?php endif; ?>', '<?php if(Plugin::isEnabled(''comments'')): ?>\r\n    <?php if(comments_is_opened( $this )): ?>\r\n            \r\n        <h3>Comments (<?php echo comments_count( $this ); ?>)</h3>\r\n        <?php comments_display( $this ); ?>\r\n            \r\n        <h3>Add comment</h3>\r\n        <?php comments_display_form( $this ); ?>\r\n            \r\n    <?php endif; ?>\r\n<?php endif; ?>', '2011-05-14 18:09:15', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `count` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `language` varchar(5) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `updated_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`, `language`, `created_on`, `updated_on`, `created_by_id`, `updated_by_id`) VALUES
(1, 'Administrator', 'admin@yoursite.com', 'admin', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'ru', '2011-05-14 16:12:04', '2011-05-14 16:12:05', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
CREATE TABLE `user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`user_id`, `permission_id`) VALUES
(1, 1);
