<?php declare(strict_types=1);

namespace Tests\Unit\Exchanges;

use App\Exchanges\CoinbasePro;
use GuzzleHttp\Client;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CoinbaseProTest extends \Tests\TestCase
{
    public function test_getCandles_calls_api()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn(json_encode($this->response()));
        $guzzleMock = $this->createMock(Client::class);
        $guzzleMock->expects($this->once())->method('get')->willReturn($response);

        (new CoinbasePro($guzzleMock))->getCandles('btc-eur', 1, 2, 3);
    }

    public function test_getCandles_composes_query()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn(json_encode($this->response()));
        $guzzleMock = $this->createMock(Client::class);
        $guzzleMock->expects($this->once())->method('get')->with($this->anything(), $this->callback(function(array $request) {
            return $request['query']['pair'] === 'btc-eur' &&
                $request['query']['start'] === 1 &&
                $request['query']['end'] === 3 &&
                $request['query']['period'] === 2/60 .'m';
        }))->willReturn($response);

        (new CoinbasePro($guzzleMock))->getCandles('btc-eur', 1, 2, 3);
    }

    public function test_getCandles_creates_candles_dto()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn(json_encode($this->response()));
        $guzzleMock = $this->createMock(Client::class);
        $guzzleMock->expects($this->once())->method('get')->willReturn($response);

        $candles = (new CoinbasePro($guzzleMock))->getCandles('btc-eur', 1, 2, 3);
        $response = $this->response();
        $this->assertEquals($response[0]['Close'], $candles->getCandles()[0]->close);
        $this->assertEquals($response[0]['Open'], $candles->getCandles()[0]->open);
        $this->assertEquals($response[0]['High'], $candles->getCandles()[0]->high);
        $this->assertEquals($response[0]['Low'], $candles->getCandles()[0]->low);
        $this->assertEquals('btc-eur', $candles->getCandles()[0]->pair);
    }


    private function response() : array
    {
        return [
            ['Open' => 223344.54, 'High' => 223.44,  'Low' => 333.22, 'Close' => 23423.64, 'BaseVolume' => 24.543, 'QuoteVolume' => 0.002]
        ];
    }
}
