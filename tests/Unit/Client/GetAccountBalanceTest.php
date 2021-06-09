<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetAccountBalanceTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "ZUSD": "171288.6158",
    "ETH2": "2.5885574330",
    "DOT": "0.5000000000",
    "PAXG": "0",
    "USD.M": "1213029.2780"
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/Balance?nonce=1234567890', $json
        )->getAccountBalance();

        $this->assertCount(5, $response);

        $this->assertEquals('ZUSD', $response['ZUSD']->getAsset());
        $this->assertEquals('171288.6158', (string) $response['ZUSD']->getBalance());

        $this->assertEquals('ETH2', $response['ETH2']->getAsset());
        $this->assertEquals('2.5885574330', (string) $response['ETH2']->getBalance());

        $this->assertEquals('DOT', $response['DOT']->getAsset());
        $this->assertEquals('0.5000000000', (string) $response['DOT']->getBalance());

        $this->assertEquals('PAXG', $response['PAXG']->getAsset());
        $this->assertEquals('0', (string) $response['PAXG']->getBalance());

        $this->assertEquals('USD.M', $response['USD.M']->getAsset());
        $this->assertEquals('1213029.2780', (string) $response['USD.M']->getBalance());
    }

    function test_success_response_without_balances()
    {
        $json = <<<EOL
{
  "error": []
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/private/Balance?nonce=1234567890', $json
        )->getAccountBalance();

        $this->assertCount(0, $response);
    }
}