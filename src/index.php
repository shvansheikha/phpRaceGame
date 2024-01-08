<?php

require 'vendor/autoload.php';

function readTheJSONFile()
{
    $json = file_get_contents('vehicles.json');
    return json_decode($json, true);
}

$vehiclesList = readTheJSONFile();

$vehiclesListSize = count($vehiclesList);

for ($i = 0; $i <= $vehiclesListSize - 1; $i++) {
    echo "$i:" . $vehiclesList[$i]['name'] . "\n";
}

