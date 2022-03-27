<?php declare(strict_types=1);

namespace App;

class Candle
{
    public function __construct(
        public float $open,
        public float $close,
        public float $low,
        public float $high,
    )
    {

    }
}
