<?php declare(strict_types=1);

namespace App\Exchanges;

use App\Candle;
use App\Candles;
use GuzzleHttp\Client;

class CoinbasePro implements Exchange
{

    private const URI = "http://cryptohopper-ticker-frontend.us-east-1.elasticbeanstalk.com/v1/coinbasepro/candles";
    public function __construct(protected Client $client)
    {

    }

    public function getCandles(string $pair, int $start, int $periodInSeconds, int $end) : Candles
    {
        $response = $this->client->get(self::URI, [
            'query' => compact('pair', 'start', 'end') + ['period' => $periodInSeconds / 60 . 'm']
        ]);

        $candles = array_map(
            fn($candle) => new Candle($candle['Open'], $candle['Close'], $candle['Low'], $candle['High']),
            json_decode((string) $response->getBody(), true)
        );
        return new Candles(...$candles);
    }

    public function key(): string
    {
        return 'coinbase-pro';
    }
}
