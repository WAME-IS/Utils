<?php

namespace Wame\Utils;

use Nette\Utils\Random;

class Security
{
    /**
     * Generate token
     *
     * @param int $length length
     * @param string $charlist characters list
     * @return string
     */
    public static function generateToken($length = 32, $charlist = '0-9a-z')
    {
        return Random::generate($length, $charlist);
    }

}