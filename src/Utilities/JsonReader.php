<?php

namespace App\Utilities;

use App\Traits\IsSingleton;

class JsonReader
{
    use IsSingleton;

    public function readTheJSONFile($file)
    {
        $json = file_get_contents($file);

        return json_decode($json, true);
    }
}