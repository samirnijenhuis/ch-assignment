<?php declare(strict_types=1);

namespace App\Listeners;

class DisplaySignalType
{
    public function handle(\App\Events\Signal $signal)
    {
        echo $signal->type->name;
    }
}
