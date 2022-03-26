<?php declare(strict_types=1);

namespace App\Events;

enum SignalType
{
    case BUY;
    case SELL;
    case NEUTRAL;
}
