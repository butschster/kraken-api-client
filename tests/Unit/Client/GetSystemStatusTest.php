<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetSystemStatusTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
    "error": [ ],
    "result": {
        "status": "online",
        "timestamp": "2021-03-21T15:33:02Z"
    }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/SystemStatus', $json
        )->getSystemStatus();

        $this->assertEquals('online', $response->status);
        $this->assertTrue($response->isOnline());
        $this->assertEquals('2021-03-21T15:33:02+00:00', $response->timestamp->format(DATE_RFC3339));
    }

}