<?php

if ( !defined( 'DEBUG' ) )
	die;

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
 * @subpackage models
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * Class Layout
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since Frog version 0.1
 */
class Layout extends Record {
	const TABLE_NAME = 'layout';

	public $name;
	public $content_type;
	public $content;
	public $parts_type;
	public $created_on;
	public $updated_on;
	public $created_by_id;
	public $updated_by_id;

	public function beforeInsert()
	{
		$this->created_by_id = AuthUser::getId();
		$this->created_on = date( 'Y-m-d H:i:s' );
		return true;
	}

	public function beforeUpdate()
	{
		$this->updated_by_id = AuthUser::getId();
		$this->updated_on = date( 'Y-m-d H:i:s' );
		return true;
	}

	public function beforeSave()
	{
		//$this->parts_type = implode( ',', $this->parts_type );
		$this->content = stripslashes( $this->content );

		return true;
	}


	public static function find( $args = null )
	{
		// Collect attributes...
		$where = isset( $args['where'] ) ? trim( $args['where'] ) : '';
		$order_by = isset( $args['order'] ) ? trim( $args['order'] ) : '';
		$offset = isset( $args['offset'] ) ? (int) $args['offset'] : 0;
		$limit = isset( $args['limit'] ) ? (int) $args['limit'] : 0;

		// Prepare query parts
		$where_string = empty( $where ) ? '' : "WHERE $where";
		$order_by_string = empty( $order_by ) ? '' : "ORDER BY $order_by";
		$limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';

		$tablename = self::tableNameFromClassName( 'Layout' );
		$tablename_user = self::tableNameFromClassName( 'User' );

		// Prepare SQL
		$sql = "SELECT $tablename.*, creator.name AS created_by_name, updator.name AS updated_by_name FROM $tablename" .
				" LEFT JOIN $tablename_user AS creator ON $tablename.created_by_id = creator.id" .
				" LEFT JOIN $tablename_user AS updator ON $tablename.updated_by_id = updator.id" .
				" $where_string $order_by_string $limit_string";

		$stmt = self::$__CONN__->prepare( $sql );
		$stmt->execute();

		// Run!
		if ( $limit == 1 )
		{
			return $stmt->fetchObject( 'Layout' );
		}
		else
		{
			$objects = array();
			while ( $object = $stmt->fetchObject( 'Layout' ) )
			{
				$objects[] = $object;
			}
			return $objects;
		}
	}



	public static function findAll( $args = null )
	{
		return self::find( $args );
	}

	public static function findById( $id )
	{
		return self::find( array(
			'where' => self::tableNameFromClassName( 'Layout' ) . '.id=' . (int) $id,
			'limit' => 1
		) );
	}

	public function isUsed()
	{
		return Record::countFrom( 'Page', 'layout_id=?', array($this->id) );
	}

}

// end Layout class
