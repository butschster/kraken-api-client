![kraken](https://user-images.githubusercontent.com/773481/121415892-dc088c80-c970-11eb-9ce2-66de76749a44.jpg)

# The most powerful and extendable REST API / Websocket client for Kraken.com. Built on PHP8.0

This is an unofficial Kraken.com PHP8.0 package, which should help users very quickly connect to API from their Laravel or other php project.
Of course, the primary feature of this package is the ability to interact with [Kraken REST API](https://docs.kraken.com/rest/), but also it allows connecting to [Kraken Websocket server](https://docs.kraken.com/websockets/).

[![Support me on Patreon](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Fshieldsio-patreon.vercel.app%2Fapi%3Fusername%3Dbutschster%26type%3Dpatrons&style=flat)](https://patreon.com/butschster)
[![Build Status](https://github.com/butschster/kraken-api-client/actions/workflows/php.yml/badge.svg)](https://github.com/butschster/kraken-api-client/actions/workflows/php.yml)
[![Packagist Downloads](https://img.shields.io/packagist/dt/butschster/kraken-api-client)](https://packagist.org/packages/butschster/kraken-api-client)
[![License](https://poser.pugx.org/butschster/meta-tags/license)](https://packagist.org/packages/butschster/kraken-api-client)

## Features
- REST API client
- Websocket client
- Well documented
- Well tested


## Requirements
- Laravel 8.x, Laravel 9.x, Laravel 10.x, or other framework
- PHP 8.0 and above

## Installation
Require this package with composer using the following command:
`composer require butschster/kraken-api-client`

## Using

### Laravel Autodiscovery
If you're using Laravel 8.0+ or above, the package will automatically register the KrakenServiceProvider.

### Other PHP frameworks

**REST API client**
```php
$client = new \Butschster\Kraken\Client(
    new GuzzleHttp\Client(),
    new \Butschster\Kraken\NonceGenerator(),
    (new \Butschster\Kraken\Serializer\SerializerFactory())->build(),
    'api-key',
    'api-secret'
);

$client->getAccountBalance();
```

**Websocket client**
```php
$client = new \Butschster\Kraken\WebsocketClient(
   (new \Butschster\Kraken\Serializer\SerializerFactory())->build(),
   \React\EventLoop\Factory::create()
);

$client->connectToPublicServer(...);
```

#### Configuration

You can update your .env file with the following:
```
KRAKEN_KEY=my_api_key
KRAKEN_SECRET=my_secret
KRAKEN_OTP=my_otp_key # if two-factor enabled, otherwise not required
```

## REST API methods

#### API client usage

By using dependency injection
```php
use App\Http\Controllers\Controller;
use Butschster\Kraken\Contracts\Client;

class BalanceController extends Controller {

    public function getBalance(Client $client)
    {
        $balances = $client->getAccountBalance();
       
        ...
    }
}
```

### Make request
This package uses [jms/serializer](https://jmsyst.com/libs/serializer) for converting API responses to object, so you have to pass class, 
that will use for deserializing.

*Note: For non exists API methods you have to create response classes by your self.*

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

// Public request
$client->request('public/Spread', RecentSpreadsResponse::class, array $params): RecentSpreadsResponse;

// Private request
$balance = $client->request('private/Balance', \Butschster\Kraken\Responses\AccountBalanceResponse::class, array $params);
```

**If request return an error, will be thrown an exception `\Butschster\Kraken\Exceptions\KrakenApiErrorException`**

### Get Server Time
Get the server's time.

See: https://docs.kraken.com/rest/#operation/getServerTime

```php
/** @var \Butschster\Kraken\Contracts\Client $client */
$response = $client->getServerTime();

$response->time; // DateTimeInterface
$response->rfc1123; // string:"Sun, 21 Mar 21 14:23:14 +0000
```

### Get System Status
Get the current system status or trading mode.

See: https://docs.kraken.com/rest/#operation/getSystemStatus

```php
/** @var \Butschster\Kraken\Contracts\Client $client */
$response = $client->getSystemStatus();

$response->status; // string:"online"
$response->timestamp; // DateTimeImmutable
```

### Get Asset Info
Get information about the assets that are available for deposit, withdrawal, trading and staking.

See: https://docs.kraken.com/rest/#operation/getAssetInfo

```php
use Butschster\Kraken\ValueObjects\AssetClass;

/** @var \Butschster\Kraken\Contracts\Client $client */
$response = $client->getAssetInfo(array $assets = ['all'], ?AssetClass $class = null);

foreach ($response as $asset => $info) {
    $asset; // string: "XXBT"
    
    $info->class; // string:"currency"
    $info->altname; // string:"XBT"
    $info->decimals; // int:10
    $info->displayDecimals; // int:5
}
```

### Get Tradable Asset Pairs
Get tradable asset pairs

See: https://docs.kraken.com/rest/#operation/getTradableAssetPairs

```php
use Butschster\Kraken\ValueObjects\AssetPair;
use Butschster\Kraken\ValueObjects\TradableInfo;
use Butschster\Kraken\Responses\Entities\Fee;

/** @var \Butschster\Kraken\Contracts\Client $client */

$pair = new AssetPair('XXBTCZUSD', 'XETHXXBT');
$info = TradableInfo::leverage();

$response = $client->getTradableAssetPairs($pair, $info);

foreach ($response as $pair => $assetPair) {
    $pair ;// string:"XETHXXBT"
    
    $assetPair->altname; // string:"ETHXBT"
    $assetPair->wsname; // string:"ETH/XBT"
    $assetPair->classBase; // string:"currency"
    $assetPair->base; // string:"XETH"
    $assetPair->classQuote; // string:"currency"
    $assetPair->quote; // string:"XXBT"
    $assetPair->pairDecimals; // int:5
    $assetPair->lotDecimals; // int:8
    $assetPair->lotMultiplier; // int:1
    $assetPair->leverageBuy; // array:[2,3,4,5]
    $assetPair->leverageSell; // array:[2,3,4,5]
    $assetPair->feeVolumeCurrency; // string:"ZUSD"
    $assetPair->marginCall; // int:80
    $assetPair->marginStop; // int:40
    $assetPair->ordermin; // string:"0.005"
    
    foreach ($assetPair->fees as $fee) {
        $fee->getPercentFee(); // float:0.2
        $fee->getVolume(); // int:2500000
    }
    
    foreach ($assetPair->feesMaker as $fee) {
        $fee->getPercentFee(); // float:0.2
        $fee->getVolume(); // int:2500000
    }
    
}
```

### Get Ticker Information
Note: Today's prices start at midnight UTC

See: https://docs.kraken.com/rest/#operation/getTickerInformation

```php
use Brick\Math\BigDecimal;

/** @var \Butschster\Kraken\Contracts\Client $client */
$response = $client->getTickerInformation(['XBTUSD', 'XXBTZUSD', ...]);

foreach ($response as $pair => $tickerInfo) {
    $pair; // string: "XXBTZUSD"
    
    $tickerInfo->ask->getLotVolume(); // BigDecimal
    $tickerInfo->ask->getPrice(); // BigDecimal
    $tickerInfo->ask->getWholeLotVolume(); // BigDecimal
    
    $tickerInfo->bid->getLotVolume(); // BigDecimal
    $tickerInfo->bid->getPrice(); // BigDecimal
    $tickerInfo->bid->getWholeLotVolume(); // BigDecimal
    
    $tickerInfo->lastTradeClosed[0]; // string:"52641.10000"
    $tickerInfo->lastTradeClosed[1]; // string:"0.00080000"
    
    $tickerInfo->volume->getLast24Hours(); // BigDecimal
    $tickerInfo->volume->getToday(); // BigDecimal
    
    $tickerInfo->volumeWightedAveragePrice->getLast24Hours(); // BigDecimal
    $tickerInfo->volumeWightedAveragePrice->getToday(); // BigDecimal
    
    $tickerInfo->trades->getLast24Hours(); // int:0
    $tickerInfo->trades->getToday(); // int:10
    
    $tickerInfo->low->getToday(); // BigDecimal
    $tickerInfo->low->getLast24Hours(); // BigDecimal
    
    $tickerInfo->high->getToday(); // BigDecimal
    $tickerInfo->high->getLast24Hours(); // BigDecimal
    
    $tickerInfo->openingPrice; // BigDecimal
}
```

### Get Order Book
See: https://docs.kraken.com/rest/#operation/getOrderBook

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getOrderBook(['XBTUSD', 'XXBTZUSD'], 100);

foreach ($response as $pair => $orders) {
    foreach ($orders->asks as $order) {
        $order->getPrice(); // BigDecimal
        $order->getVolume(); // BigDecimal
        $order->getTimestamp(); // int:1616663113
        $order->getDate(); // DateTimeInterface
    }
    
    foreach ($orders->bids as $order) {
        $order->getPrice(); // BigDecimal
        $order->getVolume(); // BigDecimal
        $order->getTimestamp(); // int:1616663113
        $order->getDate(); // DateTimeInterface
    }
}
```

### Get Account Balance
Retrieve all cash balances, net of pending withdrawals.

See: https://docs.kraken.com/rest/#operation/getAccountBalance

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getAccountBalance();

foreach ($response as $balance) {
    $balance->getAsset(); // string:"ZUSD"
    $balance->getBalance(); // BigDecimal
}
```

### Get Trade Balance
Retrieve a summary of collateral balances, margin position valuations, equity and margin level.

See: https://docs.kraken.com/rest/#operation/getTradeBalance

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getTradeBalance();

$response->equivalentBalance; // BigDecimal
$response->tradeBalance; // BigDecimal
$response->marginAmount; // BigDecimal
$response->net; // BigDecimal
$response->cost; // BigDecimal
$response->valuation; // BigDecimal
$response->equity; // BigDecimal
$response->freeMargin; // BigDecimal
$response->marginLevel; // BigDecimal
```

### Get Open Orders
Retrieve information about currently open orders.

See: https://docs.kraken.com/rest/#operation/getOpenOrders

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getOpenOrders();

foreach ($response as $txId => $order) {
    $txId; // string:"OQCLML-BW3P3-BUCMWZ"
    
    $order->refId; // string|null
    $order->userRef; // int:0
    $order->status; // string:"online"
    $order->openTimestamp; // int:1616666559.8974
    $order->startTimestamp; // int:0
    $order->expireTimestamp; // int:0
    
    $order->description->pair; // string:"XBTUSD"
    $order->description->type; // string:"buy"
    $order->description->orderType; // string:"limit"
    $order->description->price; // BigDecimal
    $order->description->secondaryPrice; // BigDecimal
    $order->description->leverage; // string:"none"
    $order->description->order; // string:"buy 1.25000000 XBTUSD @ limit 30010.0"
    $order->description->close; // string:""
    
    $order->volume; // BigDecimal
    $order->volumeExecuted; // BigDecimal
    $order->cost; // BigDecimal
    $order->fee; // BigDecimal
    $order->price; // BigDecimal
    $order->stopPrice; // BigDecimal
    $order->limitPrice; // BigDecimal
    $order->miscellaneous; // array<string>
    $order->flags; // array:["fciq"]
    $order->trades; // array:["TCCCTY-WE2O6-P3NB37"]
}
```

### Get Closed Orders
Retrieve information about orders that have been closed (filled or cancelled). 50 results are returned at a time, the most recent by default.
Note: If an order's tx ID is given for start or end time, the order's opening time (opentm) is used

See: https://docs.kraken.com/rest/#operation/getClosedOrders

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$start = \Carbon\Carbon::now()->subDay();
$end = \Carbon\Carbon::now();

$response = $client->getClosedOrders(
    start: $start, end: $end, offset: 100
);

$response->count; // 5

foreach ($response->closed as $txId => $order) {
    $txId; // string:"OQCLML-BW3P3-BUCMWZ"
    
    $order->refId; // string|null
    $order->userRef; // int:0
    $order->status; // string:"canceled"
    $order->reason; // string:"User requested"
    $order->openTimestamp; // int:1616666559.8974
    $order->startTimestamp; // int:0
    $order->expireTimestamp; // int:0
    
    $order->description->pair; // string:"XBTUSD"
    $order->description->type; // string:"buy"
    $order->description->orderType; // string:"limit"
    $order->description->price; // BigDecimal
    $order->description->secondaryPrice; // BigDecimal
    $order->description->leverage; // string:"none"
    $order->description->order; // string:"buy 1.25000000 XBTUSD @ limit 30010.0"
    $order->description->close; // string:""
    
    $order->volume; // BigDecimal
    $order->volumeExecuted; // BigDecimal
    $order->cost; // BigDecimal
    $order->fee; // BigDecimal
    $order->price; // BigDecimal
    $order->stopPrice; // BigDecimal
    $order->limitPrice; // BigDecimal
    $order->miscellaneous; // array<string>
    $order->flags; // array:["fciq"]
    $order->trades; // array:["TCCCTY-WE2O6-P3NB37"]
}
```

### Query Orders Info
Retrieve information about specific orders.

See: https://docs.kraken.com/rest/#operation/getOrdersInfo

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->queryOrdersInfo(['OBCMZD-JIEE7-77TH3F', 'OMMDB2-FSB6Z-7W3HPO']);

foreach ($response as $txId => $order) {
    $txId; // string:"OQCLML-BW3P3-BUCMWZ"
    
    $order->refId; // string|null
    $order->userRef; // int:0
    $order->status; // string:"canceled"
    $order->reason; // string:"User requested"
    $order->openTimestamp; // int:1616666559.8974
    $order->startTimestamp; // int:0
    $order->expireTimestamp; // int:0
    
    $order->description->pair; // string:"XBTUSD"
    $order->description->type; // string:"buy"
    $order->description->orderType; // string:"limit"
    $order->description->price; // BigDecimal
    $order->description->secondaryPrice; // BigDecimal
    $order->description->leverage; // string:"none"
    $order->description->order; // string:"buy 1.25000000 XBTUSD @ limit 30010.0"
    $order->description->close; // string:""
    
    $order->volume; // BigDecimal
    $order->volumeExecuted; // BigDecimal
    $order->cost; // BigDecimal
    $order->fee; // BigDecimal
    $order->price; // BigDecimal
    $order->stopPrice; // BigDecimal
    $order->limitPrice; // BigDecimal
    $order->miscellaneous; // array<string>
    $order->flags; // array:["fciq"]
    $order->trades; // array:["TCCCTY-WE2O6-P3NB37"]
}
```

### Add Order
Place a new order.
Note: See the AssetPairs endpoint for details on the available trading pairs, their price and quantity precisions, order minimums, available leverage, etc.

See: https://docs.kraken.com/rest/#operation/addOrder

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Butschster\Kraken\ValueObjects\CloseOrder;
use Butschster\Kraken\ValueObjects\OrderDirection;
use Butschster\Kraken\ValueObjects\OrderType;


$order = new \Butschster\Kraken\Requests\AddOrderRequest(
    OrderType::stopLoss(), OrderDirection::sell(), 'XXBTZUSD'
);

$order->setCloseOrder(new CloseOrder(OrderType::stopLoss(), '38000', '36000'));
$order->setPrice('45000.1');
$order->...

$response = $client->addOrder($order);

$response->description->order; // string:"sell 2.12340000 XBTUSD @ limit 45000.1 with 2:1 leverage"
$response->description->close; // string:"close position @ stop loss 38000.0 -> limit 36000.0"
$response->txId; // array:["OUF4EM-FRGI2-MQMWZD"]
```

### Cancel Order
Cancel a particular open order (or set of open orders) by txid or userref

See: https://docs.kraken.com/rest/#operation/cancelOrder

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

$response = $client->cancelOrder('OYVGEW-VYV5B-UUEXSK');
$response; // int:1
```

### Cancel All Orders
Cancel all open orders

See: https://docs.kraken.com/rest/#operation/cancelAllOrders

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

$response = $client->cancelAllOrders();
$response; // int:1
```

### Cancel All Orders After X
CancelAllOrdersAfter provides a "Dead Man's Switch" mechanism to protect the client from network malfunction, extreme latency or unexpected matching engine downtime. The client can send a request with a timeout (in seconds), that will start a countdown timer which will cancel all client orders when the timer expires. The client has to keep sending new requests to push back the trigger time, or deactivate the mechanism by specifying a timeout of 0. If the timer expires, all orders are cancelled and then the timer remains disabled until the client provides a new (non-zero) timeout.

The recommended use is to make a call every 15 to 30 seconds, providing a timeout of 60 seconds. This allows the client to keep the orders in place in case of a brief disconnection or transient delay, while keeping them safe in case of a network breakdown. It is also recommended to disable the timer ahead of regularly scheduled trading engine maintenance (if the timer is enabled, all orders will be cancelled when the trading engine comes back from downtime - planned or otherwise).

See: https://docs.kraken.com/rest/#operation/cancelAllOrdersAfter

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

$response = $client->cancelAllOrdersAfter(60);
$response->currentTime; // DateTimeInterface
$response->triggerTime; // DateTimeInterface
```

### Get Deposit Methods
Retrieve methods available for depositing a particular asset.

See: https://docs.kraken.com/rest/#operation/getDepositMethods

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getDepositMethods('XBT');
$response->method; // string:"Bitcoin"
$response->limit; // int|bool:false
$response->fee; // BigDecimal
$response->generatedAddress; // bool:true
$response->addressSetupFee; // string:""
```

### Get Deposit Addresses
Retrieve (or generate a new) deposit addresses for a particular asset and method.

See: https://docs.kraken.com/rest/#operation/getDepositAddresses

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

$response = $client->getDepositAddresses('XBT', 'Bitcoin');

foreach ($response as $address) {
    $address->address; // string:"2N9fRkx5JTWXWHmXzZtvhQsufvoYRMq9ExV"
    $address->expireTimestamp; // int:0
    $address->new; // bool:true
}
```

### Get Withdrawal Information
Retrieve fee information about potential withdrawals for a particular asset, key and amount.

See: https://docs.kraken.com/rest/#operation/getWithdrawalInformation

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

use Brick\Math\BigDecimal;

$response = $client->getWithdrawalInformation('XBT', 'btc_testnet_with1', BigDecimal::of(0.725));

$response->method; // string:"Bitcoin"
$response->limit; // BigDecimal
$response->amount; // BigDecimal
$response->fee; // BigDecimal
```

### Get Websockets Token
An authentication token must be requested via this REST API endpoint in order to connect to and authenticate with our Websockets API. The token should be used within 15 minutes of creation, but it does not expire once a successful Websockets connection and private subscription has been made and is maintained.

See: https://docs.kraken.com/rest/#operation/getWebsocketsToken

```php
/** @var \Butschster\Kraken\Contracts\Client $client */

$response = $client->getWebsocketsToken();
$response->token; // string:"1Dwc4lzSwNWOAwkMdqhssNNFhs1ed606d1WcF3XfEMw"
$response->expires; // int:900
$response->expiresAt(); // DateTimeInterface
```

---

## Websocket Client

### Websocket client usage

By using dependency injection

```php
namespace App\Console\Commands\ExampleCommand;

use Butschster\Kraken\Contracts\WebsocketClient;
use Butschster\Kraken\Websocket\Connection;

class ExampleCommand extends Command 
{
    ...
    
    public function handle(WebsocketClient $client)
    {
        $client->connectToPublicServer(function (Connection $connection) {
        
            ...
        
        });
    }
}
```

### Ping
Client can ping server to determine whether connection is alive, server responds with pong. This is an application level ping as opposed to default ping in websockets standard which is server initiated

See: https://docs.kraken.com/websockets/#message-ping

```php
/** @var \Butschster\Kraken\Contracts\WebsocketClient $client */

use Butschster\Kraken\Websocket\Connection;
use Butschster\Kraken\Websocket\Requests\Ping;
use Butschster\Kraken\Websocket\Timer;

$client->connectToPublicServer(function (Connection $connection) {
    $connection->sendEvent(new Ping());
    
    // or
    
    $connection->addPeriodicTimer(
        new Timer(5, new Ping())
    );
});


$client->connectToPrivateServer('websocket-token', function (Connection $connection) {
    ...
});
```

### HeartBeat
Server heartbeat sent if no subscription traffic within 1 second (approximately)

See: https://docs.kraken.com/websockets/#message-heartbeat

```php
/** @var \Butschster\Kraken\Contracts\WebsocketClient $client */

use Butschster\Kraken\Websocket\Connection;
use Butschster\Kraken\Websocket\Requests\HeartBeat;
use Butschster\Kraken\Websocket\Timer;

$client->connectToPublicServer(function (Connection $connection) {
    $connection->sendEvent(new HeartBeat());
    
    // or
    
    $connection->addPeriodicTimer(
        new Timer(5, new HeartBeat())
    );
});
```

### Subscribe to an event
Subscribe to a topic on a single or multiple currency pairs.

See: https://docs.kraken.com/websockets/#message-subscribe

```php
/** @var \Butschster\Kraken\Contracts\WebsocketClient $client */

use Butschster\Kraken\Websocket\Connection;
use Butschster\Kraken\Websocket\Requests\Subscribe;

$client->connectToPublicServer(function (Connection $connection) {
    $connection->sendEvent(
        new Subscribe(
            'ticker',
            ["XBT/USD", "XBT/EUR"]
        )
    );
    
    $connection->onMessage(function (string $message) {
        // Handle message
    });
});
```

### Custom events
You can create you own events

```php
/** @var \Butschster\Kraken\Contracts\WebsocketClient $client */

// For public events you have to use \Butschster\Kraken\Contracts\WebsocketEvent interface
// For private events you have to use \Butschster\Kraken\Contracts\PrivateWebsocketEvent interface

class OwnTradesEvent implements \Butschster\Kraken\Contracts\PrivateWebsocketEvent {
    public string $event = 'subscribe';
    public array $subscription = [
        'name' => 'ownTrades'
    ];
    
    public function setToken(string $token) : void{
        $this->subscription['token'] = $toke;
    }
}

$client->connectToPrivateServer('token', function (Connection $connection) {
    $connection->sendEvent(
        new OwnTradesEvent()
    );
});
```

# Enjoy!
