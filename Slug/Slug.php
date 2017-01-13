<?php

namespace Wame\Utils;

/**
 * Class Slug
 * @package Wame\Utils
 * @deprecated
 */
class Slug
{
	const TITLE = 0;
	
	/**
	 * Generate
	 * 
	 * @param integer $type		type
	 * @param variadic $values	values
	 */
	public static function generate($type, ...$values)
	{
		switch($type) {
			case self::TITLE:
				return createTitle($values[0]);
			default:
				return createRegex($type, $values);
		}
	}
	
	/**
	 * Generate by title
	 * 
	 * @param string $title		title
	 */
	public static function generateByTitle($title)
	{
		return Strings::webalize($title);
	}
	
	/**
	 * Generate by pattern
	 * 
	 * @param string $pattern	pattern
	 * @param array $values		values
	 */
	public static function generateByPattern($pattern, $values)
	{
		preg_match_all("/\[[^\]]*\]/", $text, $matches);
	}
	
}