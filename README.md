## How to run

 - `$ composer install`
 - `$ php artisan test`
 - `$ php artisan serve`
 - [https://localhost:8000/](https://localhost:8000/)


## Assignment
Create a microservice to return a signal based on the Simple Moving Average (SMA) indicator for any given exchange, market and period.
In this example we will work with Coinbase Pro and BTC-EUR market, but we should be options to send to the service.

Binance Chart: hhttps://www.binance.com/en/trade/BTC_EUR?layout=pro
Valid periods: 1m, 5m, 15m, 30m, 1h, 2h, 4h, 1d

### Get Charts
URL: http://cryptohopper-ticker-frontend.us-east-1.elasticbeanstalk.com/v1/{exchange}/candles?pair={market}&start={start_unix_timestamp}&end={end_unix_timestamp}&period={period}
Example: http://cryptohopper-ticker-frontend.us-east-1.elasticbeanstalk.com/v1/coinbasepro/candles?pair=BTC-EUR&start=1621371923&end=1621425923&period=30m

### SMA indicator
The simple moving average indicator uses the "close" values of the chart.
For the signal we need to use the SMA with a length of 8 and a length of 55. That means that for the first SMA we will use the last 8 close values for our average, and 55, 55 close values.

Docs: https://www.investopedia.com/terms/s/sma.asp#:~:text=A%20simple%20moving%20average%20(SMA)%20is%20an%20arithmetic%20moving%20average,periods%20in%20the%20calculation%20average.

### Signal calculation
If the SMA(8) is currently lower than SMA(55), but previous value was higher or the same, signal a sell.
If the SMA(8) is higher than SMA(55) and previous value was lower or same, signal a buy.
Otherwise signal neutral.

### Get Ticker Prices
For a more accurate live signal, the last close value needs to be replaced with tha "last" value from the ticker.
URL: http://cryptohopper-ticker-frontend.us-east-1.elasticbeanstalk.com/v1/{exchange}/ticker
Example: http://cryptohopper-ticker-frontend.us-east-1.elasticbeanstalk.com/v1/coinbasepro/ticker
