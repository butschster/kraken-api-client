<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Butschster\Kraken\Contracts\AddOrderRequest;
use Kraken\Tests\TestCase;
use Mockery as m;

class AddOrderTest extends TestCase
{
    private string $json;
    private \Mockery\LegacyMockInterface|AddOrderRequest|\Mockery\MockInterface $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->json = <<<EOL
{
  "error": [],
  "result": {
    "descr": {
      "order": "buy 2.12340000 XBTUSD @ limit 45000.1 with 2:1 leverage",
      "close": "close position @ stop loss 38000.0 -> limit 36000.0"
    },
    "txid": [
      "OUF4EM-FRGI2-MQMWZD"
    ]
  }
}
EOL;
        $this->request = m::mock(AddOrderRequest::class);
        $this->request->shouldReceive('toArray')->andReturn(['foo' => 'bar']);
    }

    function test_success_response()
    {
        $response = $this->createClient(
            'https://api.kraken.com/0/private/AddOrder?foo=bar&nonce=1234567890', $this->json
        )->addOrder($this->request);

        $this->assertEquals(['OUF4EM-FRGI2-MQMWZD'], $response->txId);
        $this->assertEquals('buy 2.12340000 XBTUSD @ limit 45000.1 with 2:1 leverage', $response->description->order);
        $this->assertEquals('close position @ stop loss 38000.0 -> limit 36000.0', $response->description->close);
    }
}