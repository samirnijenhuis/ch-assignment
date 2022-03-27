<?php declare(strict_types=1);

namespace App\Indicators;

interface MovingAverage extends Indicator
{
    public function calculate($offset = 0) : float;
}
