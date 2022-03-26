<?php declare(strict_types=1);

namespace App\Strategies;

use App\Candles;
use App\Events\Signal;
use App\Events\SignalType;
use App\Indicators\SimpleMovingAverage;

class SimpleMovingAverageCrossover
{

    public function __construct(protected Candles $candles)
    {
    }

    public function execute(int $source1, int $source2)
    {
       $sma1 = new SimpleMovingAverage($source1, ...$this->candles->getCandles());
       $sma2 = new SimpleMovingAverage($source2, ...$this->candles->getCandles());

       if($sma1->calculate() < $sma2->calculate() && $sma1->calculate(1) >= $sma2->calculate(1)) {
           event(new Signal(SignalType::SELL));
       }

       if($sma1->calculate() > $sma2->calculate() && $sma1->calculate(1)  <= $sma2->calculate(1) ) {
           event(new Signal(SignalType::BUY));
       }

       event(new Signal(SignalType::NEUTRAL));

    }
}
