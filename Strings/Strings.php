<?php

namespace Wame\Utils;

use Nette\Utils\Strings as NStrings;

class Strings
{
	/**
	 * Truncate string
	 * 
	 * @param string $string
	 * @param int $length
	 * @param string $append
	 * @return string
	 */
	static function truncate($string, $length = 100, $append = '&hellip;') 
	{
		$string = trim($string);

		if (strlen($string) > $length) {
			$string = wordwrap($string, $length);
			$string = explode("\n", $string, 2);
			$string = $string[0] . $append;
		}

		return $string;
	}
    
    
	/**
	 * Convert string to CamelCase
	 * 
	 * @param string $string
	 * @param boolean $capitalizeFirstCharacter
	 * @return string
	 */
    static function dashesToCamelCase($string, $capitalizeFirstCharacter = false) 
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', NStrings::webalize($string))));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
	
	
	/**
	 * Get class name from namespace
	 * 
	 * @param string $namespace
	 * @return string
	 */
	static function getClassName($namespace)
	{
		$reflect = new \ReflectionClass($namespace);
		
		return $reflect->getShortName();
	}
    
	static function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	static function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
	
}