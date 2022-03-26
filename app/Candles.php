<?php declare(strict_types=1);

namespace App;

class Candles
{
    protected array $candles;

    public function __construct(Candle ...$candles)
    {
        $this->candles = $candles;
    }

    public function getCandles() : array
    {
        return $this->candles;
    }
}
