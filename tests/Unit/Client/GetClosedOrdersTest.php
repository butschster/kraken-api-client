<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Carbon\Carbon;
use Kraken\Tests\TestCase;

class GetClosedOrdersTest extends TestCase
{
    private string $json;

    protected function setUp(): void
    {
        parent::setUp();

        $this->json = <<<EOL
{
  "error": [],
  "result": {
    "closed": {
      "O37652-RJWRT-IMO74O": {
        "refid": null,
        "userref": 36493663,
        "status": "canceled",
        "reason": "User requested",
        "opentm": 1616148493.7708,
        "closetm": 1616148610.0482,
        "starttm": 0,
        "expiretm": 0,
        "descr": {
          "pair": "XBTGBP",
          "type": "buy",
          "ordertype": "limit",
          "price": "2506.0",
          "price2": "0",
          "leverage": "none",
          "order": "buy 0.00100000 XBTGBP @ limit 2506.0",
          "close": ""
        },
        "vol": "0.00100000",
        "vol_exec": "0.00000000",
        "cost": "0.00000",
        "fee": "0.00000",
        "price": "0.00000",
        "stopprice": "0.00000",
        "limitprice": "0.00000",
        "misc": "",
        "oflags": "fciq"
      },
      "O6YDQ5-LOMWU-37YKEE": {
        "refid": null,
        "userref": 36493663,
        "status": "canceled",
        "reason": "User requested",
        "opentm": 1616148493.7708,
        "closetm": 1616148610.0477,
        "starttm": 0,
        "expiretm": 0,
        "descr": {
          "pair": "XBTGBP",
          "type": "buy",
          "ordertype": "limit",
          "price": "2518.0",
          "price2": "0",
          "leverage": "none",
          "order": "buy 0.00100000 XBTGBP @ limit 2518.0",
          "close": ""
        },
        "vol": "0.00100000",
        "vol_exec": "0.00000000",
        "cost": "0.00000",
        "fee": "0.00000",
        "price": "0.00000",
        "stopprice": "0.00000",
        "limitprice": "0.00000",
        "misc": "",
        "oflags": "fciq"
      }
    },
    "count": 2
  }
}
EOL;
    }

    function test_success_response()
    {
        $response = $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&nonce=1234567890', $this->json
        )->getClosedOrders();

        $this->assertEquals(2, $response->count);

        $this->assertNull($response->closed['O37652-RJWRT-IMO74O']->refId);
        $this->assertEquals(36493663, $response->closed['O37652-RJWRT-IMO74O']->userRef);
        $this->assertEquals('canceled', $response->closed['O37652-RJWRT-IMO74O']->status);
        $this->assertEquals('User requested', $response->closed['O37652-RJWRT-IMO74O']->reason);
        $this->assertEquals(1616148493.7708, $response->closed['O37652-RJWRT-IMO74O']->openTimestamp);
        $this->assertEquals(1616148610.0482, $response->closed['O37652-RJWRT-IMO74O']->closeTimestamp);
        $this->assertEquals(0, $response->closed['O37652-RJWRT-IMO74O']->startTimestamp);
        $this->assertEquals(0, $response->closed['O37652-RJWRT-IMO74O']->expireTimestamp);
        $this->assertEquals('0.00100000', (string) $response->closed['O37652-RJWRT-IMO74O']->volume);
        $this->assertEquals('0.00000000', (string) $response->closed['O37652-RJWRT-IMO74O']->volumeExecuted);
        $this->assertEquals('0.00000', (string) $response->closed['O37652-RJWRT-IMO74O']->cost);
        $this->assertEquals('0.00000', (string) $response->closed['O37652-RJWRT-IMO74O']->fee);
        $this->assertEquals('0.00000', (string) $response->closed['O37652-RJWRT-IMO74O']->price);
        $this->assertEquals('0.00000', (string) $response->closed['O37652-RJWRT-IMO74O']->stopPrice);
        $this->assertEquals('0.00000', (string) $response->closed['O37652-RJWRT-IMO74O']->limitPrice);
        $this->assertEquals([], $response->closed['O37652-RJWRT-IMO74O']->miscellaneous);
        $this->assertEquals(['fciq'], $response->closed['O37652-RJWRT-IMO74O']->flags);

        $this->assertEquals('XBTGBP', $response->closed['O37652-RJWRT-IMO74O']->description->pair);
        $this->assertEquals('buy', $response->closed['O37652-RJWRT-IMO74O']->description->type);
        $this->assertEquals('limit', $response->closed['O37652-RJWRT-IMO74O']->description->orderType);
        $this->assertEquals('2506.0', (string)$response->closed['O37652-RJWRT-IMO74O']->description->price);
        $this->assertEquals('0', (string)$response->closed['O37652-RJWRT-IMO74O']->description->secondaryPrice);
        $this->assertEquals('none', $response->closed['O37652-RJWRT-IMO74O']->description->leverage);
        $this->assertEquals('buy 0.00100000 XBTGBP @ limit 2506.0', $response->closed['O37652-RJWRT-IMO74O']->description->order);
        $this->assertEquals('', $response->closed['O37652-RJWRT-IMO74O']->description->close);
    }

    function test_request_with_start_date()
    {
        Carbon::setTestNow('2020-01-01 00:00:00');
        $start = Carbon::now();

        $response = $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&start=1577836800&nonce=1234567890', $this->json
        )->getClosedOrders(
            start: $start
        );
    }

    function test_request_with_end_date()
    {
        Carbon::setTestNow('2020-01-01 00:00:00');
        $end = Carbon::now();

        $response = $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&end=1577836800&nonce=1234567890', $this->json
        )->getClosedOrders(
            end: $end
        );
    }

    function test_request_with_tx_id()
    {
        $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&start=O6YDQ5-LOMWU-37YKEA&end=O6YDQ5-LOMWU-37YKEE&nonce=1234567890', $this->json
        )->getClosedOrders(
            start: 'O6YDQ5-LOMWU-37YKEA',
            end: 'O6YDQ5-LOMWU-37YKEE'
        );
    }

    function test_request_with_offset()
    {
        $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&ofs=10&nonce=1234567890', $this->json
        )->getClosedOrders(
            offset: 10
        );
    }

    function test_request_with_closetime()
    {
        $this->createClient(
            'https://api.kraken.com/0/private/ClosedOrders?trades=0&closetime=close&nonce=1234567890', $this->json
        )->getClosedOrders(
            closeTime: 'close'
        );
    }
}