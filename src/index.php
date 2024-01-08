<?php

require 'vendor/autoload.php';

function readTheJSONFile()
{
    $json = file_get_contents('vehicles.json');
    return json_decode($json, true);
}

function calculateTime($vehicle, $distance)
{
    return $distance / $vehicle['maxSpeed'] * 1000;
}

$vehiclesList = readTheJSONFile();

$vehiclesListSize = count($vehiclesList);

for ($i = 0; $i <= $vehiclesListSize - 1; $i++) {
    echo "$i:" . $vehiclesList[$i]['name'] . "\n";
}

$message = "Player %s choose an item between 0-" . ($vehiclesListSize - 1);

$playerOneVehicle = cli\prompt(sprintf($message, 'One'), $default = false, $marker = ':');
$playerTwoVehicle = cli\prompt(sprintf($message, 'Two'), $default = false, $marker = ':');

$distance = cli\prompt("Input Distance", $default = false, $marker = ':');
