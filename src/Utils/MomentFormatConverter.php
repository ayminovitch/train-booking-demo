<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Utils;

class MomentFormatConverter
{
    private const FORMAT_CONVERT_RULES = [
        // year
        'yyyy' => 'YYYY', 'yy' => 'YY', 'y' => 'YYYY',
        // day
        'dd' => 'DD', 'd' => 'D',
        // day of week
        'EE' => 'ddd', 'EEEEEE' => 'dd',
        // timezone
        'ZZZZZ' => 'Z', 'ZZZ' => 'ZZ',
        // letter 'T'
        '\'T\'' => 'T',
    ];

    public function convert(string $format): string
    {
        return strtr($format, self::FORMAT_CONVERT_RULES);
    }
}
