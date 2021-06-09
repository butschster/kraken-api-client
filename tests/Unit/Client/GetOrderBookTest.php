<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetOrderBookTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "XXBTZUSD": {
      "asks": [
        [
          "52523.00000",
          "1.199",
          1616663113
        ],
        [
          "52536.00000",
          "0.300",
          1616663112
        ]
      ],
      "bids": [
        [
          "52522.90000",
          "0.753",
          1616663112
        ],
        [
          "52522.80000",
          "0.006",
          1616663109
        ]
      ]
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/Depth?pair=XBTUSD&count=100', $json
        )->getOrderBook(['XBTUSD']);

        $this->assertCount(2, $response['XXBTZUSD']->asks);
        $this->assertCount(2, $response['XXBTZUSD']->bids);

        $this->assertEquals("52523.00000", (string) $response['XXBTZUSD']->asks[0]->getPrice());
        $this->assertEquals("1.199", (string) $response['XXBTZUSD']->asks[0]->getVolume());
        $this->assertEquals(1616663113, $response['XXBTZUSD']->asks[0]->getTimestamp());
        $this->assertEquals('2021-03-25 09:05:13', $response['XXBTZUSD']->asks[0]->getDate()->format('Y-m-d H:i:s'));

        $this->assertEquals("52522.80000", (string) $response['XXBTZUSD']->bids[1]->getPrice());
        $this->assertEquals("0.006", (string) $response['XXBTZUSD']->bids[1]->getVolume());
        $this->assertEquals(1616663109, $response['XXBTZUSD']->bids[1]->getTimestamp());
        $this->assertEquals('2021-03-25 09:05:09', $response['XXBTZUSD']->bids[1]->getDate()->format('Y-m-d H:i:s'));
    }
}