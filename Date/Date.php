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
		if ($date == 'now') {
			$return = \date($format);
		} else if ($date) {
            $return = $date->format($format);
        } else {
            $return = '';
        }
         
        return $return;
	}
	
	/**
	 * Format string date to DateTime for Doctrine entity
	 * 
	 * @param DateTime $date
	 * @param string $format
	 * @return DateTime
	 */
	public static function toDateTime($date, $format = 'Y-m-d H:i:s')
	{
		if ($date == 'now') {
			return new DateTime('now');
		} else {
			return new DateTime(date($format, strtotime($date)));
		}
	}
	
}