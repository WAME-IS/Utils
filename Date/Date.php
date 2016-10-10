<?php

namespace Wame\Utils;

use DateTime;

class Date
{
    /** @var string */
    const NOW = 'now';
    
    
	/**
	 * Format DateTime to string
	 * 
	 * @param \DateTime $date
	 * @param string $format
	 * @return string
	 */
	public static function toString($date, $format = 'Y-m-d H:i:s')
	{
		if ($date == self::NOW) {
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
		if ($date == self::NOW) {
			return new \DateTime(self::NOW);
		} else {
			return new \DateTime(date($format, strtotime($date)));
		}
	}
    

    /**
	 * Czech helper time ago in words
     * https://github.com/fprochazka/nette-components/blob/master/TimeAgoInWords/Helpers.php
     * 
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
			if ($delta == 0) { return _('in a moment'); }
			if ($delta == 1) { return _('per minute'); }
			if ($delta < 45) { return sprintf(_('per %s %s'), $delta, self::plural($delta, _('minute'), _('minutes'), _('minutes'))); }
			if ($delta < 90) { return _('per hour'); }
			if ($delta < 1440) { return sprintf(_('per %s %s'), round($delta / 60), self::plural(round($delta / 60), _('hour'), _('hours'), _('hours'))); }
			if ($delta < 2880) { return _('tomorrow'); }
			if ($delta < 43200) { return sprintf(_('per %s %s'), round($delta / 1440), self::plural(round($delta / 1440), _('day'), _('days'), _('days'))); }
			if ($delta < 86400) { return _('per month'); }
			if ($delta < 525960) { return sprintf(_('per %s %s'), round($delta / 43200), self::plural(round($delta / 43200), _('month'), _('months'), _('months'))); }
			if ($delta < 1051920) { return _('per year'); }
			return sprintf(_('per %s %s'), round($delta / 525960), self::plural(round($delta / 525960), _('year'), _('years'), _('years')));
		}
        
		$delta = round($delta / 60);
        if ($delta == 0) { return _('a moment ago'); }
		if ($delta == 1) { return _('minute ago'); }
		if ($delta < 45) { return sprintf(_('%s minutes ago'), $delta); }
		if ($delta < 90) { return _('hour ago'); }
		if ($delta < 1440) { return sprintf(_('%s hours ago'), round($delta / 60)); }
		if ($delta < 2880) { return _('yesterday'); }
		if ($delta < 43200) { return sprintf(_('%s days ago'), round($delta / 1440)); }
		if ($delta < 86400) { return _('a month ago'); }
		if ($delta < 525960) { return sprintf(_('%s months ago'), round($delta / 43200)); }
		if ($delta < 1051920) { return _('a year ago'); }
        
		return sprintf(_('%s years ago'), round($delta / 525960));
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