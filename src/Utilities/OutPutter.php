<?php

namespace App\Utilities;

use App\Traits\IsSingleton;
use cli;

class OutPutter
{
    use IsSingleton;

    public function line($msg)
    {
        cli\line($msg);
    }

    public function prompt($message)
    {
        cli\prompt($message, $default = false, $marker = ':');
    }
}