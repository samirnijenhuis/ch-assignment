<?php declare(strict_types=1);

namespace Tests\Unit\Indicators;

use App\Candle;
use App\Indicators\SimpleMovingAverage;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SimpleMovingAverageTest extends TestCase
{
    public function test_it_assumes_length_is_smaller_than_candle_size()
    {
        $this->expectException(InvalidArgumentException::class);
        new SimpleMovingAverage(2, new Candle( 0,0,0,0));
    }

    public function test_calculate_calculates_moving_average()
    {
        $candles = [
            new Candle(0, 2, 0, 0),
            new Candle(0, 4, 0, 0),
            new Candle(0, 6, 0, 0),
        ];

        $this->assertEquals(4, (new SimpleMovingAverage(3, ...$candles))->calculate());
    }

    public function test_calculate_applies_length()
    {
        $candles = [
            new Candle(0, 2, 0, 0),
            new Candle(0, 4, 0, 0),
            new Candle(0, 6, 0, 0),
        ];

        $this->assertEquals(5, (new SimpleMovingAverage(2, ...$candles))->calculate());
    }

    public function test_calculate_applies_offset()
    {
        $candles = [
            new Candle(0, 2, 0, 0),
            new Candle(0, 4, 0, 0),
            new Candle(0, 6, 0, 0),
        ];

        $this->assertEquals(3, (new SimpleMovingAverage(2, ...$candles))->calculate(1));
    }
}
