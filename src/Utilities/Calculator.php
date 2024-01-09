<?php

namespace App\Utilities;

use stdClass;

class Calculator
{
    /**
     * @throws \Exception
     */
    public function calculateTime($vehicle, $distance): stdClass
    {
        $time = new stdClass();

        $speed = Converter::getInstance()->convert($vehicle['unit'], $vehicle['maxSpeed']);

        $time->time = round(($distance / $speed), 2);

        $time->hours = intval($time->time);
        $time->minutes = round(($time->time - $time->hours) * 60);

        return $time;
    }
}