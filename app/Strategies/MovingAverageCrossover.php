<?php declare(strict_types=1);

namespace App\Strategies;

use App\Events\Signal;
use App\Events\SignalType;
use App\Indicators\MovingAverage;

class MovingAverageCrossover
{
    public function __construct(protected string $pair)
    {
    }

    public function execute(MovingAverage $source1, MovingAverage $source2)
    {
        $current1 =  $source1->calculate();
        $current2 = $source2->calculate();
        $previous1 = $source1->calculate(1);
        $previous2 = $source2->calculate(1);

        switch(true) {
            case $current1 < $current2 && $previous1 >= $previous2:
                event(new Signal(SignalType::SELL, $this->pair));
                break;
            case $current1 > $current2 && $previous1  <= $previous2:
                event(new Signal(SignalType::BUY, $this->pair));
                break;
            default:
                event(new Signal(SignalType::NEUTRAL, $this->pair));
                break;
        }
    }
}
