<?php

namespace App\Models;

use App\Traits\IsSingleton;
use App\Utilities\JsonReader;

class Vehicles
{
    use IsSingleton;

    private array $vehicles;

    public function __construct()
    {
        $this->vehicles = JsonReader::getInstance()->readTheJSONFile('vehicles.json');
    }

    public function getVehicles()
    {
        return $this->vehicles;
    }

    public function getVehicle($index)
    {
        return $this->vehicles[$index];
    }

    public function size()
    {
        return count($this->vehicles);
    }
}