<?php

namespace Wame\Utils;


trait TMonthShort
{
    /**
     * Get month shorts list
     *
     * @return array
     */
    public static function getMonthShortList()
    {
        return [1 => _('Jan'), 2 => _('Feb'), 3 => _('Mar'), 4 => _('Apr'), 5 => _('May'), 6 => _('Jun'), 7 => _('Jul'), 8 => _('Aug'), 9 => _('Sep'), 10 => _('Oct'), 11 => _('Nov'), 12 => _('Dec')];
    }


    /**
     * Get month short by id
     *
     * @param int $month
     *
     * @return string
     */
    public static function getMonthShort(int $month)
    {
        return self::getMonthList()[$month];
    }

}
