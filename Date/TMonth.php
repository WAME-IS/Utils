<?php

namespace Wame\Utils;


trait TMonth
{
    /**
     * Get month list
     *
     * @return array
     */
    public static function getMonthList()
    {
        return [1 => _('January'), 2 => _('February'), 3 => _('March'), 4 => _('April'), 5 => _('May'), 6 => _('June'), 7 => _('July'), 8 => _('August'), 9 => _('September'), 10 => _('October'), 11 => _('November'), 12 => _('December')];
    }


    /**
     * Get month by id
     *
     * @param int $month
     *
     * @return string
     */
    public static function getMonth(int $month)
    {
        return self::getMonthList()[$month];
    }

}
