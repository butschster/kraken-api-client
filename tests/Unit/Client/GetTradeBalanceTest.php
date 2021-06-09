<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetTradeBalanceTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "eb": "1101.3425",
    "tb": "392.2264",
    "m": "7.0354",
    "n": "-10.0232",
    "c": "21.1063",
    "v": "31.1297",
    "e": "382.2032",
    "mf": "375.1678",
    "ml": "5432.57"
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/TradeBalance?asset=ZUSD&nonce=1234567890', $json
        )->getTradeBalance('ZUSD');

        $this->assertEquals("1101.3425", (string) $response->equivalentBalance);
        $this->assertEquals("392.2264", (string) $response->tradeBalance);
        $this->assertEquals("7.0354", (string) $response->marginAmount);
        $this->assertEquals("-10.0232", (string) $response->net);
        $this->assertEquals("21.1063", (string) $response->cost);
        $this->assertEquals("31.1297", (string) $response->valuation);
        $this->assertEquals("382.2032", (string) $response->equity);
        $this->assertEquals("375.1678", (string) $response->freeMargin);
        $this->assertEquals("5432.57", (string) $response->marginLevel);
    }
}