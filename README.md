# Kraken.com exchange API, PHP 7 package.

[![Support me on Patreon](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Fshieldsio-patreon.vercel.app%2Fapi%3Fusername%3Dbutschster%26type%3Dpatrons&style=flat)](https://patreon.com/butschster)
[![Packagist Downloads](https://img.shields.io/packagist/dt/butschster/kraken-api-client)](https://packagist.org/packages/butschster/kraken-api-client)
[![License](https://poser.pugx.org/butschster/meta-tags/license)](https://packagist.org/packages/butschster/kraken-api-client)



## Installation

Require this package with composer using the following command:
`composer require butschster/kraken-api-client`

## Using

### Laravel

#### Laravel 5.5+
If you're using Laravel 5.5 or above, the package will automatically register the Kraken provider and facade.

#### Laravel 5.4 and below

Add Butschster\Kraken\KrakenServiceProvider to the providers array in your `config/app.php`:
```php
'providers' => [
    // Other service providers...

    Butschster\Kraken\KrakenServiceProvider::class,
],
```

If you want to use the facade interface, you can use the facade class when needed:
```php
use Butschster\Kraken\Facade\Kraken;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Kraken' => Butschster\Kraken\Facade\Kraken::class,
],
```

#### Configuration

You can update your .env file with the following:
```
KRAKEN_KEY=my_api_key
KRAKEN_SECRET=my_secret
KRAKEN_OTP=my_otp_key # if two-factor enabled, otherwise not required
```

#### Usage

By using facade
```php
use Butschster\Kraken\Facade\Kraken;

$balances = Kraken::getAccountBalance(); 
// Will return Butschster\Kraken\Objects\BalanceCollection

foreach($balances as $balance) {
    $currency = $balance->currency();
    $amount = $balance->amount();
}
```

By using dependency injection
```php
use Butschster\Kraken\Contracts\Client;

class BalanceConstroller extends Controller {

    public function getBalance(Client $client)
    {
        $client->getAccountBalance();
        ...
    }
}
```

### Checking minimal volume size

See https://support.kraken.com/hc/en-us/articles/205893708-What-is-the-minimum-order-size-

#### Check minimal order size for pair
```php
$orderVolume = new \Butschster\Kraken\OrderVolume;
$pair = $client->getAssetPairs('EOSETH')->first();
$isValidSize = $orderVolume->checkMinimalSizeForPair($pair, 1.1);
```

#### Check minimal order size for currency
```php
$orderVolume = new \Butschster\Kraken\OrderVolume;
$isValidSize = $orderVolume->checkMinimalSizeForPair('EOS', 1.1);
```

#### Get minimal order size
```php
$orderVolume = new \Butschster\Kraken\OrderVolume;

// Pair
$pair = $client->getAssetPairs('EOSETH')->first();
$minimalsize = $orderVolume->getMinimalSizeForPair($pair);

// Currency
$minimalsize = $orderVolume->getMinimalSize('EOS');
```


### API methods

#### Make request

```php
$client->request(string $method, array $parameters, bool $isPublic) : array;

// Public request
$trades = $client->request('Trades', ['pair' => 'BCHXBT']);

// Private request
$balance = $client->request('Balance', [], false);
```

**If request return an error, will be thrown an exception `Butschster\Kraken\Exceptions\KrakenApiErrorException`**

#### Get tradable asset pairs
https://www.kraken.com/help/api#get-tradable-pairs

```php
$pairs = $client->getAssetPairs(string|array $pair, string $info='all') : Butschster\Kraken\Objects\PairCollection;

foreach($pairs as $pair) {
    $pair->name();
}
```

#### Get ticker information
https://www.kraken.com/help/api#get-ticker-info

```php
$pairs = $client->getTicker(string|array $pair) : Butschster\Kraken\Objects\TickerCollection;

foreach($pairs as $pair) {
    $pair->name();
    $pair->askPrice();
    $pair->askWholeLotVolume();
    $pair->askLotVolume();
    $pair->askLotVolume();
    ...
}
```

#### Get account balance
https://www.kraken.com/help/api#get-account-balance

```php
$balances = $client->getAccountBalance() : Butschster\Kraken\Objects\BalanceCollection;

foreach($balances as $balance) {
    $currency = $balance->currency();
    $amount = $balance->amount();
}
```

#### Get open orders
https://www.kraken.com/help/api#get-open-orders

```php
$orders = $client->getOpenOrders(bool $trades = false) : Butschster\Kraken\Objects\OrdersCollection;
```

#### Get closed orders
https://www.kraken.com/help/api#get-closed-orders

```php
$orders = $client->getClosedOrders(bool $trades = false, Carbon\Carbon $start = null, Carbon\Carbon $end = null) : Butschster\Kraken\Objects\OrdersCollection;
```

#### Add new order
https://www.kraken.com/help/api#add-standard-order

```php
use Butschster\Kraken\Contracts\Order as OrderContract;

$order = new Butschster\Kraken\Order('BCHUSD', OrderContract::TYPE_BUY, OrderContract::ORDER_TYPE_MARKET, 20);

$orderStatus = $client->addOrder($order) : Butschster\Kraken\Objects\OrderStatus;

$txid = $orderStatus->getTransactionId();
$desciption = $orderStatus->getDescription() = Butschster\Kraken\Objects\OrderStatusDescription;
```

#### Cancel open order
https://www.kraken.com/help/api#cancel-open-order

```php
$client->cancelOrder(string $transactionId): array;
```
