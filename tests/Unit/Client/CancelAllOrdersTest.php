<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class CancelAllOrdersTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "count": 4
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/CancelAll?nonce=1234567890', $json
        )->cancelAllOrders();

        $this->assertEquals(4, $response);
    }
}