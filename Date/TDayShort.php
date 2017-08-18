<?php

namespace Wame\Utils;


trait TDayShort
{
    /**
     * Get day short list
     *
     * @return array
     */
    public static function getDayShortList()
    {
        return [1 => _('Mon'), 2 => _('Tue'), 3 => _('Wed'), 4 => _('Thu'), 5 => _('Fri'), 6 => _('Sat'), 7 => _('Sun')];
    }


    /**
     * Get day short by id
     *
     * @param int $day
     *
     * @return string
     */
    public static function getShortDay(int $day)
    {
        return self::getDayList()[$day];
    }

}
