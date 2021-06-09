<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Brick\Math\BigDecimal;
use Kraken\Tests\TestCase;

class GetWithdrawalInformationTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "method": "Bitcoin",
    "limit": "332.00956139",
    "amount": "0.72485000",
    "fee": "0.00015000"
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/WithdrawInfo?asset=XBT&key=btc_testnet_with1&amount=0.725&nonce=1234567890', $json
        )->getWithdrawalInformation('XBT', 'btc_testnet_with1', BigDecimal::of('0.725'));

        $this->assertEquals('Bitcoin', $response->method);
        $this->assertEquals("332.00956139", (string) $response->limit);
        $this->assertEquals("0.72485000", (string) $response->amount);
        $this->assertEquals("0.00015000", (string) $response->fee);
    }
}
