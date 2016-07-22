<?php

namespace Wame\Utils;

use DateTime;

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
			return new \DateTime('now');
		} else {
			return new \DateTime(date($format, strtotime($date)));
		}
	}
    
    
    // source: https://github.com/fprochazka/nette-components/blob/master/TimeAgoInWords/Helpers.php
    
    /**
	 * Czech helper time ago in words.
	 * @param  int
	 * @return string
	 */
	public static function timeAgoInWords($time)
	{
		if (!$time) {
			return FALSE;
		} elseif (is_numeric($time)) {
			$time = (int) $time;
		} elseif ($time instanceof DateTime) {
			$time = $time->format('U');
        } else {
			$time = strtotime($time);
		}
        
		$delta = time() - $time;
        
		if ($delta < 0) {
			$delta = round(abs($delta) / 60);
			if ($delta == 0) return 'za okamžik';
			if ($delta == 1) return 'za minutu';
			if ($delta < 45) return 'za ' . $delta . ' ' . self::plural($delta, 'minuta', 'minuty', 'minut');
			if ($delta < 90) return 'za hodinu';
			if ($delta < 1440) return 'za ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hodina', 'hodiny', 'hodin');
			if ($delta < 2880) return 'zítra';
			if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dní');
			if ($delta < 86400) return 'za měsíc';
			if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'měsíc', 'měsíce', 'měsíců');
			if ($delta < 1051920) return 'za rok';
			return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let');
		}
        
		$delta = round($delta / 60);
		if ($delta == 0) return 'před okamžikem';
		if ($delta == 1) return 'před minutou';
		if ($delta < 45) return "před $delta minutami";
		if ($delta < 90) return 'před hodinou';
		if ($delta < 1440) return 'před ' . round($delta / 60) . ' hodinami';
		if ($delta < 2880) return 'včera';
		if ($delta < 43200) return 'před ' . round($delta / 1440) . ' dny';
		if ($delta < 86400) return 'před měsícem';
		if ($delta < 525960) return 'před ' . round($delta / 43200) . ' měsíci';
		if ($delta < 1051920) return 'před rokem';
        
		return 'před ' . round($delta / 525960) . ' lety';
	}
    
    
	/**
	 * Plural: three forms, special cases for 1 and 2, 3, 4.
	 * (Slavic family: Slovak, Czech)
	 * @param  int
	 * @return mixed
	 */
	private static function plural($n)
	{
		$args = func_get_args();
		return $args[($n == 1) ? 1 : (($n >= 2 && $n <= 4) ? 2 : 3)];
	}
	
}