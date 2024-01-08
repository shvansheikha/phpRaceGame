<?php

namespace Utilities;

use traits\IsSingleton;

class JsonReader
{
    use IsSingleton;

    public function readTheJSONFile($file)
    {
        $json = file_get_contents($file);

        return json_decode($json, true);
    }
}