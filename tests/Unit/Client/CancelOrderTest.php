<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class CancelOrderTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "count": 3
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/CancelOrder?txid=OYVGEW-VYV5B-UUEXSK&nonce=1234567890', $json
        )->cancelOrder('OYVGEW-VYV5B-UUEXSK');

        $this->assertEquals(3, $response);
    }
}