<?php declare(strict_types=1);

namespace Tests\Unit\Exchanges;

use App\Exceptions\ExchangeNotFoundException;
use App\Exchanges\Exchange;
use App\Exchanges\ExchangeFactory;

class ExchangeFactoryTest extends \Tests\TestCase
{
    public function test_it_throws_if_no_matching_exchange_found()
    {
        $this->expectException(ExchangeNotFoundException::class);
        (new ExchangeFactory())->make('test');
    }

    public function test_it_gets_matching_exchange_by_key()
    {
        $exchange1 = $this->createMock(Exchange::class);
        $exchange1->expects($this->once())->method('key')->willReturn('test-a');

        $exchange2 = $this->createMock(Exchange::class);
        $exchange2->expects($this->once())->method('key')->willReturn('test-b');

        $this->assertEquals(
            $exchange2,
            (new ExchangeFactory($exchange1, $exchange2))->make('test-b')
        );

    }
}
