<?php declare(strict_types=1);

namespace App\Exchanges;

use App\Candles;

interface Exchange
{
    public function getCandles(string $pair, int $start, int $periodInSeconds, int $end) : Candles;

    public function key() : string;
}
