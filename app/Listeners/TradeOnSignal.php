<?php declare(strict_types=1);

namespace App\Listeners;

class TradeOnSignal
{
    public function handle(\App\Events\Signal $signal)
    {
        echo sprintf("Execute %s on %s", $signal->type->name, $signal->pair);
    }
}
