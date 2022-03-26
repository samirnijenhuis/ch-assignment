<?php

namespace App\Http\Controllers;

use App\Exchanges\CoinbasePro;
use App\Exchanges\ExchangeFactory;
use App\Strategies\SimpleMovingAverageCrossover;

class Controller
{
    public function trade(ExchangeFactory $exchangeFactory)
    {
        $candles = $exchangeFactory->make()->getCandles('BTC-EUR', 1621371923, 1800, 1621425923 + 60*60*20);

        (new SimpleMovingAverageCrossover($candles))->execute(8, 55);
    }
}
