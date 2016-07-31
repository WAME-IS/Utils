<?php

namespace Wame\Utils;

use Nette\Reflection\ClassType;
use Nette\Utils\Strings as NStrings;

class Strings extends NStrings
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
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', self::webalize($string, null, false))));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
     * Get class name from namespace
     * 
     * @param string $namespace
     * @param boolean $capitalizeFirstCharacter
     * @return string
     */
    static function getClassName($namespace, $capitalizeFirstCharacter = true)
    {
        $reflect = new ClassType($namespace);

        $className = $reflect->getShortName();

        if (!$capitalizeFirstCharacter) {
            $className[0] = strtolower($className[0]);
        }

        return $className;
    }

    static function parseTemplate($template, $parameters)
    {
        return Strings::replace($template, '!\{\{(\w+)\}\}!', function($m) use($parameters) {
                return $parameters[$m[1]];
            });
    }

    static function plural($string)
    {
        $last_letter = strtolower($string[strlen($string) - 1]);
        switch ($last_letter) {
            case 'y':
                return substr($string, 0, -1) . 'ies';
            case 's':
                return $string . 'es';
            default:
                return $string . 's';
        }
    }
}
