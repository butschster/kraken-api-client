<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class CancelOrdersAfterTimeoutTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "currentTime": "2021-03-24T17:41:56Z",
    "triggerTime": "2021-03-24T17:42:56Z"
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/CancelAllOrdersAfter?timeout=120&nonce=1234567890', $json
        )->cancelAllOrdersAfter(120);

        $this->assertEquals('2021-03-24 17:41:56', $response->currentTime->format('Y-m-d H:i:s'));
        $this->assertEquals('2021-03-24 17:42:56', $response->triggerTime->format('Y-m-d H:i:s'));
    }
}