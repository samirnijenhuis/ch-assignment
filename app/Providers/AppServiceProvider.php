<?php

namespace App\Providers;

use App\Events\Signal;
use App\Exchanges\CoinbasePro;
use App\Exchanges\Exchange;
use App\Exchanges\ExchangeFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private const EXCHANGES = [
        CoinbasePro::class,
    ];

    public function register()
    {
        $this->app->when(ExchangeFactory::class)->needs(Exchange::class)->give(self::EXCHANGES);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(Signal::class, \App\Listeners\DisplaySignalType::class);
    }
}
