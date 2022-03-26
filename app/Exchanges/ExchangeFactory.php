<?php declare(strict_types=1);

namespace App\Exchanges;

use App\Exceptions\ExchangeNotFoundException;

class ExchangeFactory
{
    private array $exchanges;

    public function __construct(Exchange ...$exchanges)
    {
        $this->exchanges = $exchanges;
    }

    public function make($key = 'coinbase-pro') : Exchange
    {
        $exchange =  array_filter($this->exchanges, fn(Exchange $exchange) => $exchange->key() === $key);
        if(empty($exchange)){
            throw new ExchangeNotFoundException("Exchange with key [{$key}] net found.");
        }

        return $exchange[0];
    }
}
