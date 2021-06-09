<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetDepositMethodsTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": [
    {
      "method": "Bitcoin",
      "limit": false,
      "fee": "0.0000000000",
      "gen-address": true
    }
  ]
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/DepositMethods?asset=XBT&nonce=1234567890', $json
        )->getDepositMethods('XBT');

        $this->assertEquals('Bitcoin', $response->method);
        $this->assertFalse($response->limit);
        $this->assertEquals("0.0000000000", (string) $response->fee);
        $this->assertTrue($response->generatedAddress);
    }
}
