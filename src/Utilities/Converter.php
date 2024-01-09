<?php

namespace App\Utilities;

use App\Traits\IsSingleton;
use Exception;

class Converter
{
    use IsSingleton;

    public function convert($unit, $speed): float
    {
        return match ($unit) {
            'Km/h' => $speed,
            'knots', 'Kts' => $speed * 1.852,
            default => throw new Exception("undefined unit"),
        };
    }
}