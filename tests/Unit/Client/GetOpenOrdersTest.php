<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetOpenOrdersTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "open": {
      "OQCLML-BW3P3-BUCMWZ": {
        "refid": "test-id",
        "userref": 0,
        "status": "open",
        "opentm": 1616666559.8974,
        "starttm": 0,
        "expiretm": 0,
        "descr": {
          "pair": "XBTUSD",
          "type": "buy",
          "ordertype": "limit",
          "price": "30010.0",
          "price2": "0",
          "leverage": "none",
          "order": "buy 1.25000000 XBTUSD @ limit 30010.0",
          "close": ""
        },
        "vol": "1.25000000",
        "vol_exec": "0.37500000",
        "cost": "11253.7",
        "fee": "0.00000",
        "price": "30010.0",
        "stopprice": "0.00000",
        "limitprice": "0.00000",
        "misc": "a,b,c",
        "oflags": "fciq",
        "trades": [
          "TCCCTY-WE2O6-P3NB37"
        ]
      },
      "OB5VMB-B4U2U-DK2WRW": {
        "refid": null,
        "userref": 120,
        "status": "open",
        "opentm": 1616665899.5699,
        "starttm": 0,
        "expiretm": 0,
        "descr": {
          "pair": "XBTUSD",
          "type": "buy",
          "ordertype": "limit",
          "price": "14500.0",
          "price2": "0",
          "leverage": "5:1",
          "order": "buy 0.27500000 XBTUSD @ limit 14500.0 with 5:1 leverage",
          "close": ""
        },
        "vol": "0.27500000",
        "vol_exec": "0.00000000",
        "cost": "0.00000",
        "fee": "0.00000",
        "price": "0.00000",
        "stopprice": "0.00000",
        "limitprice": "0.00000",
        "misc": "",
        "oflags": "fciq"
      }
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/OpenOrders?trades=0&nonce=1234567890', $json
        )->getOpenOrders();

        $this->assertCount(2, $response);

        $this->assertEquals('test-id', $response['OQCLML-BW3P3-BUCMWZ']->refId);
        $this->assertEquals(0, $response['OQCLML-BW3P3-BUCMWZ']->userRef);
        $this->assertEquals('open', $response['OQCLML-BW3P3-BUCMWZ']->status);
        $this->assertEquals(1616666559.8974, $response['OQCLML-BW3P3-BUCMWZ']->openTimestamp);
        $this->assertEquals(0, $response['OQCLML-BW3P3-BUCMWZ']->startTimestamp);
        $this->assertEquals(0, $response['OQCLML-BW3P3-BUCMWZ']->expireTimestamp);
        $this->assertEquals('1.25000000', (string) $response['OQCLML-BW3P3-BUCMWZ']->volume);
        $this->assertEquals('0.37500000', (string) $response['OQCLML-BW3P3-BUCMWZ']->volumeExecuted);
        $this->assertEquals('11253.7', (string) $response['OQCLML-BW3P3-BUCMWZ']->cost);
        $this->assertEquals('0.00000', (string) $response['OQCLML-BW3P3-BUCMWZ']->fee);
        $this->assertEquals('30010.0', (string) $response['OQCLML-BW3P3-BUCMWZ']->price);
        $this->assertEquals('0.00000', (string) $response['OQCLML-BW3P3-BUCMWZ']->stopPrice);
        $this->assertEquals('0.00000', (string) $response['OQCLML-BW3P3-BUCMWZ']->limitPrice);
        $this->assertEquals(['a', 'b', 'c'], $response['OQCLML-BW3P3-BUCMWZ']->miscellaneous);
        $this->assertEquals(['fciq'], $response['OQCLML-BW3P3-BUCMWZ']->flags);
        $this->assertEquals(['TCCCTY-WE2O6-P3NB37'], $response['OQCLML-BW3P3-BUCMWZ']->trades);

        $this->assertEquals('XBTUSD', $response['OQCLML-BW3P3-BUCMWZ']->description->pair);
        $this->assertEquals('buy', $response['OQCLML-BW3P3-BUCMWZ']->description->type);
        $this->assertEquals('limit', $response['OQCLML-BW3P3-BUCMWZ']->description->orderType);
        $this->assertEquals('30010.0', (string)$response['OQCLML-BW3P3-BUCMWZ']->description->price);
        $this->assertEquals('0', (string)$response['OQCLML-BW3P3-BUCMWZ']->description->secondaryPrice);
        $this->assertEquals('none', $response['OQCLML-BW3P3-BUCMWZ']->description->leverage);
        $this->assertEquals('buy 1.25000000 XBTUSD @ limit 30010.0', $response['OQCLML-BW3P3-BUCMWZ']->description->order);
        $this->assertEquals('', $response['OQCLML-BW3P3-BUCMWZ']->description->close);
    }
}