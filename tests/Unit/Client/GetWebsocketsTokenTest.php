<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Carbon\Carbon;
use Kraken\Tests\TestCase;

class GetWebsocketsTokenTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "token": "1Dwc4lzSwNWOAwkMdqhssNNFhs1ed606d1WcF3XfEMw",
    "expires": 900
  }
}
EOL;

        Carbon::setTestNow('2020-01-01 00:00:00');

        $response = $this->createClient(
            'https://api.kraken.com/0/private/GetWebSocketsToken?nonce=1234567890', $json
        )->getWebsocketsToken();

        $this->assertEquals('1Dwc4lzSwNWOAwkMdqhssNNFhs1ed606d1WcF3XfEMw', $response->token);
        $this->assertEquals(900, $response->expires);
        $this->assertEquals('2020-01-01 00:15:00', $response->expiresAt()->format('Y-m-d H:i:s'));
    }
}