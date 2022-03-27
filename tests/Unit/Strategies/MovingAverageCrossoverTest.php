<?php declare(strict_types=1);

namespace Tests\Unit\Strategies;

use App\Events\Signal;
use App\Events\SignalType;
use App\Indicators\MovingAverage;
use App\Strategies\MovingAverageCrossover;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MovingAverageCrossoverTest extends  TestCase
{

    public function test_it_signalls_sell_on_crossover()
    {
        Event::fake();

        $sma8 = $this->createMock(MovingAverage::class);
        $sma8->expects($this->exactly(2))->method('calculate')->willReturn(6.5, 5.5);
        $sma55 = $this->createMock(MovingAverage::class);
        $sma55->expects($this->exactly(2))->method('calculate')->willReturn(5.5, 8.75);
        (new MovingAverageCrossover(''))->execute($sma8, $sma55);

        Event::assertDispatched(Signal::class, fn(Signal $signal) => $signal->type === SignalType::BUY);

    }

    public function test_it_signals_buy_on_crossunder()
    {
        Event::fake();

        $sma8 = $this->createMock(MovingAverage::class);
        $sma8->expects($this->exactly(2))->method('calculate')->willReturn(11.5, 11.75);
        $sma55 = $this->createMock(MovingAverage::class);
        $sma55->expects($this->exactly(2))->method('calculate')->willReturn(20.0, 11.75);
        (new MovingAverageCrossover(''))->execute($sma8, $sma55);
        Event::assertDispatched(Signal::class, fn(Signal $signal) => $signal->type === SignalType::SELL);

    }

    public function test_it_defaults_to_neutral()
    {
        Event::fake();

        $sma8 = $this->createMock(MovingAverage::class);
        $sma8->expects($this->exactly(2))->method('calculate')->willReturn(11.5, 11.75);
        $sma55 = $this->createMock(MovingAverage::class);
        $sma55->expects($this->exactly(2))->method('calculate')->willReturn(11.5, 11.75);
        (new MovingAverageCrossover(''))->execute($sma8, $sma55);
        Event::assertDispatched(Signal::class, fn(Signal $signal) => $signal->type === SignalType::NEUTRAL);
    }
}
