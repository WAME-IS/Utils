<?php

namespace Wame\Utils;


trait TYear
{
    /**
     * Get year range
     *
     * @return array
     */
    public static function getYearRange($min = null, $max = null, $step = 1)
    {
        if ($min == null) $min = 1970;
        if ($max == null) $min = date('Y');

        return range($min, $max, $step);
    }

}
