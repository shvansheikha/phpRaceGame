<?php

namespace App\Models;

use stdClass;

class Player
{
    public array $vehicle;
    public stdClass $arrivalTime;

    public function __construct(public string $name)
    {
    }
}