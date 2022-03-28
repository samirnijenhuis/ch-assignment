<?php

namespace App\Http\Controllers;

use App\Exchanges\ExchangeFactory;
use App\Indicators\SimpleMovingAverage;
use App\Strategies\MovingAverageCrossover;

class Controller
{
    public function trade(ExchangeFactory $exchangeFactory)
    {
        $candles = $exchangeFactory->make()->getCandles('BTC-EUR', 1621371923, 1800, 1621497923);

        (new MovingAverageCrossover('BTC-EUR'))->execute(
            new SimpleMovingAverage(8, ...$candles->getCandles()),
            new SimpleMovingAverage(55, ...$candles->getCandles())
        );
    }
}
