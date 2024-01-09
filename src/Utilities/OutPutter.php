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

    public function prompt($message, $default = false, $marker = ':'): string
    {
        return cli\prompt($message, default: $default, marker: $marker);
    }

    public function choose($question, $choice = false, $default = 'n'): string
    {
        return cli\choose(question: $question, choice: $choice, default: $default);
    }
}