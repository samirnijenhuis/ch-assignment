<?php declare(strict_types=1);

namespace App\Indicators;

use App\Candle;

class SimpleMovingAverage implements MovingAverage
{
    private array $candles;
    private int $length;

    public function __construct(int $length, Candle ...$candles)
    {
        $this->length = $length;
        $this->candles = $candles;

        if(count($candles) < $length){
            throw new \InvalidArgumentException("Length of SimpleMovingAverage expected to be lower.");
        }
    }

    public function calculate($offset = 0) : float
    {
        $candles = array_map(
            fn(Candle $candle) => $candle->close,
            array_slice($this->candles, count($this->candles) - $offset - $this->length , $this->length)
        );
        return array_sum($candles) / $this->length;
    }
}
