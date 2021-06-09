<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetDepositAddressesTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": [
    {
      "address": "2N9fRkx5JTWXWHmXzZtvhQsufvoYRMq9ExV",
      "expiretm": "0",
      "new": true
    },
    {
      "address": "2Myd4eaAW96ojk38A2uDK4FbioCayvkEgVq",
      "expiretm": "0"
    }
  ]
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/DepositAddresses?asset=XBT&method=Bitcoin&new=0&nonce=1234567890', $json
        )->getDepositAddresses('XBT', 'Bitcoin');

        $this->assertEquals('2N9fRkx5JTWXWHmXzZtvhQsufvoYRMq9ExV', $response[0]->address);
        $this->assertEquals(0, $response[0]->expireTimestamp);
        $this->assertTrue($response[0]->new);

        $this->assertEquals('2Myd4eaAW96ojk38A2uDK4FbioCayvkEgVq', $response[1]->address);
        $this->assertEquals(0, $response[1]->expireTimestamp);
        $this->assertFalse($response[1]->new);
    }
}
