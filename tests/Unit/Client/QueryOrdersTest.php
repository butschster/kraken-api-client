<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class QueryOrdersTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "OBCMZD-JIEE7-77TH3F": {
      "refid": null,
      "userref": 0,
      "status": "closed",
      "reason": null,
      "opentm": 1616665496.7808,
      "closetm": 1616665499.1922,
      "starttm": 0,
      "expiretm": 0,
      "descr": {
        "pair": "XBTUSD",
        "type": "buy",
        "ordertype": "limit",
        "price": "37500.0",
        "price2": "0",
        "leverage": "none",
        "order": "buy 1.25000000 XBTUSD @ limit 37500.0",
        "close": ""
      },
      "vol": "1.25000000",
      "vol_exec": "1.25000000",
      "cost": "37526.2",
      "fee": "37.5",
      "price": "30021.0",
      "stopprice": "0.00000",
      "limitprice": "0.00000",
      "misc": "",
      "oflags": "fciq",
      "trades": [
        "TZX2WP-XSEOP-FP7WYR"
      ]
    },
    "OMMDB2-FSB6Z-7W3HPO": {
      "refid": null,
      "userref": 0,
      "status": "closed",
      "reason": null,
      "opentm": 1616592012.2317,
      "closetm": 1616592012.2335,
      "starttm": 0,
      "expiretm": 0,
      "descr": {
        "pair": "XBTUSD",
        "type": "sell",
        "ordertype": "market",
        "price": "0",
        "price2": "0",
        "leverage": "none",
        "order": "sell 0.25000000 XBTUSD @ market",
        "close": ""
      },
      "vol": "0.25000000",
      "vol_exec": "0.25000000",
      "cost": "7500.0",
      "fee": "7.5",
      "price": "30000.0",
      "stopprice": "0.00000",
      "limitprice": "0.00000",
      "misc": "",
      "oflags": "fcib",
      "trades": [
        "TJUW2K-FLX2N-AR2FLU"
      ]
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/QueryOrders?trades=0&txid=OBCMZD-JIEE7-77TH3F%2COMMDB2-FSB6Z-7W3HPO&nonce=1234567890', $json
        )->queryOrdersInfo(['OBCMZD-JIEE7-77TH3F', 'OMMDB2-FSB6Z-7W3HPO']);

        $this->assertCount(2, $response);

        $this->assertNull($response['OBCMZD-JIEE7-77TH3F']->refId);
        $this->assertEquals(0, $response['OBCMZD-JIEE7-77TH3F']->userRef);
        $this->assertEquals('closed', $response['OBCMZD-JIEE7-77TH3F']->status);
        $this->assertNull($response['OBCMZD-JIEE7-77TH3F']->reason);
        $this->assertEquals(1616665496.7808, $response['OBCMZD-JIEE7-77TH3F']->openTimestamp);
        $this->assertEquals(1616665499.1922, $response['OBCMZD-JIEE7-77TH3F']->closeTimestamp);
        $this->assertEquals(0, $response['OBCMZD-JIEE7-77TH3F']->startTimestamp);
        $this->assertEquals(0, $response['OBCMZD-JIEE7-77TH3F']->expireTimestamp);
        $this->assertEquals('1.25000000', (string) $response['OBCMZD-JIEE7-77TH3F']->volume);
        $this->assertEquals('1.25000000', (string) $response['OBCMZD-JIEE7-77TH3F']->volumeExecuted);
        $this->assertEquals('37526.2', (string) $response['OBCMZD-JIEE7-77TH3F']->cost);
        $this->assertEquals('37.5', (string) $response['OBCMZD-JIEE7-77TH3F']->fee);
        $this->assertEquals('30021.0', (string) $response['OBCMZD-JIEE7-77TH3F']->price);
        $this->assertEquals('0.00000', (string) $response['OBCMZD-JIEE7-77TH3F']->stopPrice);
        $this->assertEquals('0.00000', (string) $response['OBCMZD-JIEE7-77TH3F']->limitPrice);
        $this->assertEquals([], $response['OBCMZD-JIEE7-77TH3F']->miscellaneous);
        $this->assertEquals(['fciq'], $response['OBCMZD-JIEE7-77TH3F']->flags);
        $this->assertEquals(['TZX2WP-XSEOP-FP7WYR'], $response['OBCMZD-JIEE7-77TH3F']->trades);

        $this->assertEquals('XBTUSD', $response['OBCMZD-JIEE7-77TH3F']->description->pair);
        $this->assertEquals('buy', $response['OBCMZD-JIEE7-77TH3F']->description->type);
        $this->assertEquals('limit', $response['OBCMZD-JIEE7-77TH3F']->description->orderType);
        $this->assertEquals('37500.0', (string)$response['OBCMZD-JIEE7-77TH3F']->description->price);
        $this->assertEquals('0', (string)$response['OBCMZD-JIEE7-77TH3F']->description->secondaryPrice);
        $this->assertEquals('none', $response['OBCMZD-JIEE7-77TH3F']->description->leverage);
        $this->assertEquals('buy 1.25000000 XBTUSD @ limit 37500.0', $response['OBCMZD-JIEE7-77TH3F']->description->order);
        $this->assertEquals('', $response['OBCMZD-JIEE7-77TH3F']->description->close);
    }
}