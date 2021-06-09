<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Client;

use Butschster\Kraken\ValueObjects\AssetPair;
use Butschster\Kraken\ValueObjects\TradableInfo;
use Kraken\Tests\TestCase;

class GetTradableAssetPairsTest extends TestCase
{
    function test_success_response()
    {
        $json = <<<EOL
{
  "error": [],
  "result": {
    "XETHXXBT": {
      "altname": "ETHXBT",
      "wsname": "ETH/XBT",
      "aclass_base": "currency",
      "base": "XETH",
      "aclass_quote": "currency",
      "quote": "XXBT",
      "lot": "unit",
      "pair_decimals": 5,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [2,3,4,5],
      "leverage_sell": [3,4,5,6],
      "fees": [
        [0,0.26],
        [50000,0.24]
      ],
      "fees_maker": [
        [0,0.16],
        [50000,0.14]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "0.005"
    },
    "XXBTZUSD": {
      "altname": "XBTUSD",
      "wsname": "XBT/USD",
      "aclass_base": "currency",
      "base": "XXBT",
      "aclass_quote": "currency",
      "quote": "ZUSD",
      "lot": "unit",
      "pair_decimals": 1,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [2,3,4,5],
      "leverage_sell": [3,4,5,6],
      "fees": [
        [0,0.26],
        [50000,0.24]
      ],
      "fees_maker": [
        [0,0.16],
        [50000,0.14]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "0.0002"
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/AssetPairs?pair=XXBTCZUSD%2CXETHXXBT&info=leverage', $json
        )->getTradableAssetPairs(new AssetPair('XXBTCZUSD', 'XETHXXBT'), TradableInfo::leverage());

        $this->assertEquals('ETHXBT', $response['XETHXXBT']->altname);
        $this->assertEquals('ETH/XBT', $response['XETHXXBT']->wsname);
        $this->assertEquals('currency', $response['XETHXXBT']->classBase);
        $this->assertEquals('XETH', $response['XETHXXBT']->base);
        $this->assertEquals('currency', $response['XETHXXBT']->classQuote);
        $this->assertEquals('XXBT', $response['XETHXXBT']->quote);
        $this->assertEquals(5, $response['XETHXXBT']->pairDecimals);
        $this->assertEquals(8, $response['XETHXXBT']->lotDecimals);
        $this->assertEquals(1, $response['XETHXXBT']->lotMultiplier);
        $this->assertEquals([2, 3, 4, 5], $response['XETHXXBT']->leverageBuy);
        $this->assertEquals([3, 4, 5, 6], $response['XETHXXBT']->leverageSell);
        $this->assertEquals(0, $response['XETHXXBT']->fees[0]->getVolume());
        $this->assertEquals(0.26, $response['XETHXXBT']->fees[0]->getPercentFee());
        $this->assertEquals(50000, $response['XETHXXBT']->fees[1]->getVolume());
        $this->assertEquals(0.24, $response['XETHXXBT']->fees[1]->getPercentFee());
        $this->assertEquals(0, $response['XETHXXBT']->feesMaker[0]->getVolume());
        $this->assertEquals(0.16, $response['XETHXXBT']->feesMaker[0]->getPercentFee());
        $this->assertEquals(50000, $response['XETHXXBT']->feesMaker[1]->getVolume());
        $this->assertEquals(0.14, $response['XETHXXBT']->feesMaker[1]->getPercentFee());
        $this->assertEquals('ZUSD', $response['XETHXXBT']->feeVolumeCurrency);
        $this->assertEquals(80, $response['XETHXXBT']->marginCall);
        $this->assertEquals(40, $response['XETHXXBT']->marginStop);
        $this->assertEquals("0.005", $response['XETHXXBT']->ordermin);


        $this->assertEquals('XBTUSD', $response['XXBTZUSD']->altname);
        $this->assertEquals('XBT/USD', $response['XXBTZUSD']->wsname);
        $this->assertEquals('currency', $response['XXBTZUSD']->classBase);
        $this->assertEquals('XXBT', $response['XXBTZUSD']->base);
        $this->assertEquals('currency', $response['XXBTZUSD']->classQuote);
        $this->assertEquals('ZUSD', $response['XXBTZUSD']->quote);
        $this->assertEquals(1, $response['XXBTZUSD']->pairDecimals);
        $this->assertEquals(8, $response['XXBTZUSD']->lotDecimals);
        $this->assertEquals(1, $response['XXBTZUSD']->lotMultiplier);
        $this->assertEquals([2, 3, 4, 5], $response['XXBTZUSD']->leverageBuy);
        $this->assertEquals([3, 4, 5, 6], $response['XXBTZUSD']->leverageSell);
        $this->assertEquals(0, $response['XXBTZUSD']->fees[0]->getVolume());
        $this->assertEquals(0.26, $response['XXBTZUSD']->fees[0]->getPercentFee());
        $this->assertEquals(50000, $response['XXBTZUSD']->fees[1]->getVolume());
        $this->assertEquals(0.24, $response['XXBTZUSD']->fees[1]->getPercentFee());
        $this->assertEquals(0, $response['XXBTZUSD']->feesMaker[0]->getVolume());
        $this->assertEquals(0.16, $response['XXBTZUSD']->feesMaker[0]->getPercentFee());
        $this->assertEquals(50000, $response['XXBTZUSD']->feesMaker[1]->getVolume());
        $this->assertEquals(0.14, $response['XXBTZUSD']->feesMaker[1]->getPercentFee());
        $this->assertEquals('ZUSD', $response['XXBTZUSD']->feeVolumeCurrency);
        $this->assertEquals(80, $response['XXBTZUSD']->marginCall);
        $this->assertEquals(40, $response['XXBTZUSD']->marginStop);
        $this->assertEquals("0.0002", $response['XXBTZUSD']->ordermin);
    }
}