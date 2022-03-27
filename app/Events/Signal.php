<?php declare(strict_types=1);

namespace App\Events;

class Signal
{
    public function __construct(public SignalType $type, public string $pair)
    {

    }
}
