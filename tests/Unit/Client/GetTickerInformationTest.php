<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Kraken\Tests\TestCase;

class GetTickerInformationTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "XXBTZUSD": {
      "a": [
        "52609.60000",
        "1",
        "1.000"
      ],
      "b": [
        "52609.50000",
        "1",
        "1.000"
      ],
      "c": [
        "52641.10000",
        "0.00080000"
      ],
      "v": [
        "1920.83610601",
        "7954.00219674"
      ],
      "p": [
        "52389.94668",
        "54022.90683"
      ],
      "t": [
        23329,
        80463
      ],
      "l": [
        "51513.90000",
        "51513.90000"
      ],
      "h": [
        "53219.90000",
        "57200.00000"
      ],
      "o": "52280.40000"
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/Ticker?pair=XXBTZUSD%2CXETHXXBT', $json
        )->getTickerInformation(['XXBTZUSD', 'XETHXXBT']);

        $this->assertEquals('1.000', (string)$response['XXBTZUSD']->ask->getLotVolume());
        $this->assertEquals('52609.60000', (string)$response['XXBTZUSD']->ask->getPrice());
        $this->assertEquals('1', (string)$response['XXBTZUSD']->ask->getWholeLotVolume());

        $this->assertEquals('1.000', (string)$response['XXBTZUSD']->bid->getLotVolume());
        $this->assertEquals('52609.50000', (string)$response['XXBTZUSD']->bid->getPrice());
        $this->assertEquals('1', (string)$response['XXBTZUSD']->bid->getWholeLotVolume());

        $this->assertEquals('52280.40000', (string)$response['XXBTZUSD']->openingPrice);

        $this->assertEquals(["52641.10000", "0.00080000"], $response['XXBTZUSD']->lastTradeClosed);
        $this->assertEquals("1920.83610601", (string)$response['XXBTZUSD']->volume->getToday());
        $this->assertEquals("7954.00219674", (string)$response['XXBTZUSD']->volume->getLast24Hours());
        $this->assertEquals("52389.94668", $response['XXBTZUSD']->volumeWightedAveragePrice->getToday());
        $this->assertEquals("54022.90683", $response['XXBTZUSD']->volumeWightedAveragePrice->getLast24Hours());

        $this->assertEquals(23329, $response['XXBTZUSD']->trades->getToday());
        $this->assertEquals(80463, $response['XXBTZUSD']->trades->getLast24Hours());

        $this->assertEquals("51513.90000", (string)$response['XXBTZUSD']->low->getToday());
        $this->assertEquals("51513.90000", (string)$response['XXBTZUSD']->low->getLast24Hours());

        $this->assertEquals("53219.90000", (string)$response['XXBTZUSD']->high->getToday());
        $this->assertEquals("57200.00000", (string)$response['XXBTZUSD']->high->getLast24Hours());
    }
}