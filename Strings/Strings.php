<?php

namespace Wame\Utils;

use Nette\Reflection\ClassType;
use Nette\Utils\Strings as NStrings;

/**
 * String tools library
 *
 * @package Wame\Utils
 */
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
     * @param string $string string
     * @param bool $capitalizeFirstCharacter capitalize first letter
     * @return string
     */
    static function dashesToCamelCase(string $string, bool $capitalizeFirstCharacter = false)
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

    /**
     * Get class path
     *
     * @param mixed $class class
     * @return string
     */
    public static function getClassPath($class)
    {
        return dirname((new \ReflectionClass($class))->getFileName());
    }

    /**
     * Parse template
     *
     * @param string $template template
     * @param array $parameters parameters
     * @return string
     */
    static function parseTemplate(string $template, array $parameters)
    {
        return Strings::replace($template, '!\{\{(\w+)\}\}!', function($m) use($parameters) {
                return $parameters[$m[1]];
            });
    }

    /**
     * Get plural of string
     *
     * @param string $string string
     * @return string
     */
    static function plural(string $string)
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
