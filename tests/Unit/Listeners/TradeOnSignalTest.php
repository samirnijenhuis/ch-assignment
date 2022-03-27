<?php declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Events\Signal;
use App\Events\SignalType;
use App\Listeners\TradeOnSignal;

class TradeOnSignalTest extends \Tests\TestCase
{
    public function test_it_echoes_signal()
    {
        $this->expectOutputString("Execute BUY on BTC-USD");
        $signal = new Signal(SignalType::BUY, 'BTC-USD');
        (new TradeOnSignal)->handle($signal);
    }
}
