<?php

declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Butschster\Kraken\ValueObjects\AssetClass;
use Kraken\Tests\TestCase;

class GetAssetInfoTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
    "error": [ ],
    "result": {
        "XXBT": {
            "aclass": "currency",
            "altname": "XBT",
            "decimals": 10,
            "display_decimals": 5
        },
        "ZEUR": {
            "aclass": "currency",
            "altname": "EUR",
            "decimals": 4,
            "display_decimals": 2
        }
    }
}
EOL;

        $response = $this->createClient(
            urlWithQueryString: 'https://api.kraken.com/0/public/Assets?asset=XBT%2CETH&aclass=currency',
            json: $json,
        )->getAssetInfo(['XBT', 'ETH'], AssetClass::currency());

        $this->assertCount(2, $response);

        $this->assertEquals('currency', $response['XXBT']->class);
        $this->assertEquals('XBT', $response['XXBT']->altname);
        $this->assertEquals(10, $response['XXBT']->decimals);
        $this->assertEquals(5, $response['XXBT']->displayDecimals);

        $this->assertEquals('currency', $response['ZEUR']->class);
        $this->assertEquals('EUR', $response['ZEUR']->altname);
        $this->assertEquals(4, $response['ZEUR']->decimals);
        $this->assertEquals(2, $response['ZEUR']->displayDecimals);
    }
}
