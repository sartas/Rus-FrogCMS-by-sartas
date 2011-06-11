<?php

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
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


// Table structure for table: layout -----------------------------------------

$PDO->exec("CREATE TABLE layout (
  id             integer PRIMARY KEY NOT NULL,
  name           varchar(100) DEFAULT NULL,
  content_type   varchar(80) DEFAULT NULL,
  content        text,
  created_on     datetime DEFAULT NULL,
  updated_on     datetime DEFAULT NULL,
  created_by_id  int DEFAULT NULL,
  updated_by_id  int DEFAULT NULL,
  parts_type     text,
  position       integer DEFAULT NULL
)");
$PDO->exec("CREATE UNIQUE INDEX layout_name ON layout (name)");


// Table structure for table: page -------------------------------------------

$PDO->exec("CREATE TABLE page ( 
  id             integer PRIMARY KEY NOT NULL,
  title          varchar(255) DEFAULT NULL,
  slug           varchar(100) DEFAULT NULL,
  breadcrumb     varchar(160) DEFAULT NULL,
  keywords       varchar(255) DEFAULT NULL,
  description    text,
  parent_id      int DEFAULT NULL,
  layout_id      int DEFAULT NULL,
  behavior_id    varchar(25) NOT NULL,
  status_id      int NOT NULL DEFAULT 100,
  created_on     datetime DEFAULT NULL,
  published_on   datetime DEFAULT NULL,
  updated_on     datetime DEFAULT NULL,
  created_by_id  int DEFAULT NULL,
  updated_by_id  int DEFAULT NULL,
  position       integer DEFAULT NULL,
  is_protected   smallint NOT NULL DEFAULT 0,
  needs_login    smallint NOT NULL DEFAULT 2
)");


// Table structure for table: cached_pages --------------------------------------

$PDO->exec("CREATE TABLE cached_pages (
  id          integer PRIMARY KEY NOT NULL,
  page_id     int NOT NULL DEFAULT 0,
  url         varchar(255) DEFAULT NULL,
  created_on  datetime DEFAULT NULL
)");

$PDO->exec("CREATE INDEX cached_pages_page_id
  ON cached_pages
  (page_id)
");

$PDO->exec("CREATE UNIQUE INDEX cached_pages_url
  ON cached_pages
  (url);");



// Table structure for table: permission -------------------------------------

$PDO->exec("CREATE TABLE permission ( 
    id INTEGER NOT NULL PRIMARY KEY, 
    name varchar(25) NOT NULL 
)");
$PDO->exec("CREATE UNIQUE INDEX permission_name ON permission (name)");


// Table structure for table: setting ----------------------------------------

$PDO->exec("CREATE TABLE setting (
    name varchar(40) NOT NULL ,
    value text NOT NULL
)");
$PDO->exec("CREATE UNIQUE INDEX setting_id ON setting (name)");


// Table structure for table: plugin_settings ----------------------------------------

$PDO->exec("CREATE TABLE plugin_settings (
    plugin_id varchar(40) NOT NULL ,
    name varchar(40) NOT NULL ,
    value varchar(255) NOT NULL
)");
$PDO->exec("CREATE UNIQUE INDEX plugin_setting_id ON plugin_settings (plugin_id,name)");


// Table structure for table: snippet ----------------------------------------

$PDO->exec("CREATE TABLE snippet ( 
    id INTEGER NOT NULL PRIMARY KEY,
    name varchar(100) NOT NULL default '' , 
    filter_id varchar(25) default NULL , 
    content text , 
    content_html text , 
    created_on datetime default NULL , 
    updated_on datetime default NULL , 
    created_by_id int(11) default NULL , 
    updated_by_id int(11) default NULL,
    position mediumint(6) default NULL
)");
$PDO->exec("CREATE UNIQUE INDEX snippet_name ON snippet (name)");



// Table structure for table: user -------------------------------------------

$PDO->exec("CREATE TABLE user (
    id INTEGER NOT NULL PRIMARY KEY,
    name varchar(100) default NULL ,
    email varchar(255) default NULL ,
    username varchar(40) NOT NULL ,
    password varchar(40) default NULL ,
	language varchar(5) default NULL ,
    created_on datetime default NULL ,
    updated_on datetime default NULL ,
    created_by_id int(11) default NULL ,
    updated_by_id int(11) default NULL
)");
$PDO->exec("CREATE UNIQUE INDEX user_username ON user (username)");


// Table structure for table: user_permission --------------------------------

$PDO->exec("CREATE TABLE user_permission (
    user_id int(11) NOT NULL ,
    permission_id int(11) NOT NULL
)");
$PDO->exec("CREATE UNIQUE INDEX user_permission_user_id ON user_permission (user_id,permission_id)");


$PDO->exec("CREATE TABLE layout_part (
  id         integer PRIMARY KEY NOT NULL,
  layout_id  int NOT NULL,
  type       varchar(25) NOT NULL,
  name       varchar(25) NOT NULL,
  title      varchar(255) NOT NULL
)");

$PDO->exec("CREATE TABLE part_images (
  id         integer PRIMARY KEY NOT NULL,
  page_id    int DEFAULT NULL,
  file_name  varchar(255) DEFAULT NULL,
  alternate  varchar(255) DEFAULT NULL,
  part_id    int DEFAULT NULL
)");

$PDO->exec("CREATE TABLE part_string (
  id       integer PRIMARY KEY NOT NULL,
  content  varchar(255) DEFAULT NULL,
  part_id  int DEFAULT NULL,
  page_id  int DEFAULT NULL
)");

$PDO->exec("CREATE TABLE part_text (
  id            integer PRIMARY KEY NOT NULL,
  filter_id     varchar(25) DEFAULT NULL,
  content       text,
  content_html  text,
  part_id       int DEFAULT NULL,
  page_id       int DEFAULT NULL
)");