<?php

class Sanitize
{
	/**
	 * Reduces multiple slashes in a string to single slashes.
	 *
	 *     $str = Sanitize::reduce_slashes('foo//bar/baz'); // "foo/bar/baz"
	 *
	 * @param   string  string to reduce slashes of
	 * @return  string
	 */

	public static function reduce_slashes($str)
	{
		return preg_replace('#(?<!:)//+#', '/', $str);
	}



	public static function slug($str)
	{
		$str = preg_replace('/[^a-zа-я0-9-]+/u', '-', mb_strtolower($str, 'UTF-8'));
		$str = preg_replace('#--+#', '-', trim($str, '-'));

		return $str;
	}
}
?>
