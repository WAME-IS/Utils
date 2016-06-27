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
    
    /**
	 * Generate hash for array
     * 
	 * @param array $array
	 * @return string Hash
	 */
	public static function hash(array $array) {
		return md5(serialize($array));
	}

}
