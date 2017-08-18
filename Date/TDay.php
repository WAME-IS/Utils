<?php

namespace Wame\Utils;


trait TDay
{
    /**
     * Get day list
     *
     * @return array
     */
    public static function getDayList()
    {
        return [1 => _('Monday'), 2 => _('Tuesday'), 3 => _('Wednesday'), 4 => _('Thursday'), 5 => _('Friday'), 6 => _('Saturday'), 7 => _('Sunday')];
    }


    /**
     * Get day by id
     *
     * @param int $day
     *
     * @return string
     */
    public static function getDay(int $day)
    {
        return self::getDayList()[$day];
    }

}
