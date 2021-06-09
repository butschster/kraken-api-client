<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Butschster\Kraken\Exceptions\KrakenApiErrorException;
use Kraken\Tests\TestCase;

class GetServerTimeTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
    "error": [ ],
    "result": {
        "unixtime": 1616336594,
        "rfc1123": "Sun, 21 Mar 21 14:23:14 +0000"
    }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/Time', $json
        )->getServerTime();

        $this->assertEquals(1616336594, $response->unixtime);
        $this->assertEquals('Sun, 21 Mar 21 14:23:14 +0000', $response->rfc1123);
        $this->assertEquals('2021-03-21 14:23:14', $response->time()->format('Y-m-d H:i:s'));
    }

    function test_error_response()
    {
        $this->expectException(KrakenApiErrorException::class);
        $this->expectErrorMessage('Something went wrong: <Error 1> <Error 2>');

        $json = <<<EOL
{
    "error": ["Error 1", "Error 2"]
}
EOL;
        $this->createClient(
            'https://api.kraken.com/0/public/Time', $json
        )->getServerTime();
    }
}