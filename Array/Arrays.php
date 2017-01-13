<?php

namespace Wame\Utils;

use Nette\Utils\Arrays as NArrays;

/**
 * Array tools library
 *
 * @package Wame\Utils
 */
class Arrays extends NArrays
{	
	/**
	 * Sort by priority
	 * 
	 * @param array $types
	 * @return array
	 */
	static public function sortByPriority($types)
    {
        $return = [];

        foreach ($types as $type) {
            $return[$type['priority']][$type['name']] = $type['service']; 
        }

        // Sort by priority
        krsort($return);

        return $return;
    }

    /**
     * Get pairs
     *
     * @param array $array array
     * @param string $key key
     * @param string $value value
     * @return array
     */
    static public function getPairs($array, $key, $value = null)
    {
        $pairs = [];
        
        foreach($array as $a) {
            $pairs[$a->$key] = $value ? $a->$value : $a;
        }
        
        return $pairs;
    }

    /**
     * Convert multi-array to nice-looking string
     *
     * example:
     * from: [color => [blue, red]], to: "color-blue,red"
     *
     * @param array $array array
     * @param string $s1 separator1
     * @param string $s2 separator2
     * @param string $s3 separator3
     * @return string
     */
    static public function encodeMultiArray(array $array, $s1 = ":", $s2 = ",", $s3 = ";") // TODO: refactor to ...separators
    {
        $p = [];
        
        foreach($array as $i => $values) {
            if(is_array($values)) {
                $p[] = sprintf("%s$s1%s", $i, implode($s2, array_map(function($v) { return $v; }, $values)));
            }
        }
        
        return implode($s3, $p);
    }

    /**
     * Decode multi-array from string
     *
     * example:
     * from: "color-blue,red", to: [color => [blue, red]]
     *
     * @param string $string string
     * @param string $s1 separator1
     * @param string $s2 separator2
     * @param string $s3 separator3
     * @return array
     */
    static public function decodeMultiArray($string, $s1 = ":", $s2 = ",", $s3 = ";") // TODO: refactor to ...separators
    {
        $values = explode($s3, $string);

        $arr = [];
        foreach($values as $val) {
            $parts = explode($s1, $val);
            $arr[$parts[0]] = explode($s2, $parts[1]);
        }
        
        return $arr;
    }

}
