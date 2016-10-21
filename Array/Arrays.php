<?php

namespace Wame\Utils;

use Nette\Utils\Arrays as NArrays;

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
    
    static public function getPairs($array, $key, $value = null)
    {
        $pairs = [];
        
        foreach($array as $a) {
            $pairs[$a->$key] = $value ? $a->$value : $a;
        }
        
        return $pairs;
    }
    
    /**
     * Convert multiarray to nice-looking string
     * 
     * example:
     * from: [color => [blue, red]], to: "color-blue,red"
     * 
     * @param type $array   array
     * @return type
     */
    static public function encodeMultiArray(array $array, $s1 = ":", $s2 = ",", $s3 = ";")
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
     * 
     * @param type $string
     * @param type $s1
     * @param type $s2
     * @param type $s3
     */
    static public function decodeMultiArray($string, $s1 = ":", $s2 = ",", $s3 = ";")
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
