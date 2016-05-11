<?php

namespace Wame\Utils;

class Strings
{
	static function truncate($string, $length=100, $append="&hellip;") {
		$string = trim($string);

		if(strlen($string) > $length) {
			$string = wordwrap($string, $length);
			$string = explode("\n", $string, 2);
			$string = $string[0] . $append;
		}

		return $string;
	}
    
    
    static function dashesToCamelCase($string, $capitalizeFirstCharacter = false) 
    {

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
    
}