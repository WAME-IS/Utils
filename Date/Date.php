<?php

namespace Wame\Utils;

class Date
{
	/**
	 * Format DateTime to string
	 * 
	 * @param \DateTime $date
	 * @param string $format
	 * @return string
	 */
	public static function toString($date, $format = 'Y-m-d H:i:s')
	{
        if ($date) {
            $return = $date->format($format);
        } else {
            $return = '';
        }
         
        return $return;
	}
}