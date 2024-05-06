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
    "DOTUSDT": {
      "altname": "DOTUSDT",
      "wsname": "DOT\\/USDT",
      "aclass_base": "currency",
      "base": "DOT",
      "aclass_quote": "currency",
      "quote": "USDT",
      "lot": "unit",
      "pair_decimals": 4,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [],
      "leverage_sell": [],
      "fees": [
        [
          0,
          0.26
        ],
        [
          50000,
          0.24
        ],
        [
          100000,
          0.22
        ],
        [
          250000,
          0.2
        ],
        [
          500000,
          0.18
        ],
        [
          1000000,
          0.16
        ],
        [
          2500000,
          0.14
        ],
        [
          5000000,
          0.12
        ],
        [
          10000000,
          0.1
        ]
      ],
      "fees_maker": [
        [
          0,
          0.16
        ],
        [
          50000,
          0.14
        ],
        [
          100000,
          0.12
        ],
        [
          250000,
          0.1
        ],
        [
          500000,
          0.08
        ],
        [
          1000000,
          0.06
        ],
        [
          2500000,
          0.04
        ],
        [
          5000000,
          0.02
        ],
        [
          10000000,
          0
        ]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "0.2"
    },
    "XETHXXBT": {
      "altname": "ETHXBT",
      "wsname": "ETH\\/XBT",
      "aclass_base": "currency",
      "base": "XETH",
      "aclass_quote": "currency",
      "quote": "XXBT",
      "lot": "unit",
      "pair_decimals": 5,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [
        2,
        3,
        4,
        5
      ],
      "leverage_sell": [
        2,
        3,
        4,
        5
      ],
      "fees": [
        [
          0,
          0.26
        ],
        [
          50000,
          0.24
        ],
        [
          100000,
          0.22
        ],
        [
          250000,
          0.2
        ],
        [
          500000,
          0.18
        ],
        [
          1000000,
          0.16
        ],
        [
          2500000,
          0.14
        ],
        [
          5000000,
          0.12
        ],
        [
          10000000,
          0.1
        ]
      ],
      "fees_maker": [
        [
          0,
          0.16
        ],
        [
          50000,
          0.14
        ],
        [
          100000,
          0.12
        ],
        [
          250000,
          0.1
        ],
        [
          500000,
          0.08
        ],
        [
          1000000,
          0.06
        ],
        [
          2500000,
          0.04
        ],
        [
          5000000,
          0.02
        ],
        [
          10000000,
          0
        ]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "0.004"
    },
    "XXBTZUSD": {
      "altname": "XBTUSD",
      "wsname": "XBT\\/USD",
      "aclass_base": "currency",
      "base": "XXBT",
      "aclass_quote": "currency",
      "quote": "ZUSD",
      "lot": "unit",
      "pair_decimals": 1,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [
        2,
        3,
        4,
        5
      ],
      "leverage_sell": [
        2,
        3,
        4,
        5
      ],
      "fees": [
        [
          0,
          0.26
        ],
        [
          50000,
          0.24
        ],
        [
          100000,
          0.22
        ],
        [
          250000,
          0.2
        ],
        [
          500000,
          0.18
        ],
        [
          1000000,
          0.16
        ],
        [
          2500000,
          0.14
        ],
        [
          5000000,
          0.12
        ],
        [
          10000000,
          0.1
        ]
      ],
      "fees_maker": [
        [
          0,
          0.16
        ],
        [
          50000,
          0.14
        ],
        [
          100000,
          0.12
        ],
        [
          250000,
          0.1
        ],
        [
          500000,
          0.08
        ],
        [
          1000000,
          0.06
        ],
        [
          2500000,
          0.04
        ],
        [
          5000000,
          0.02
        ],
        [
          10000000,
          0
        ]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "0.0001"
    },
    "XXLMZUSD": {
      "altname": "XLMUSD",
      "wsname": "XLM\\/USD",
      "aclass_base": "currency",
      "base": "XXLM",
      "aclass_quote": "currency",
      "quote": "ZUSD",
      "lot": "unit",
      "pair_decimals": 6,
      "lot_decimals": 8,
      "lot_multiplier": 1,
      "leverage_buy": [
        2
      ],
      "leverage_sell": [
        2
      ],
      "fees": [
        [
          0,
          0.26
        ],
        [
          50000,
          0.24
        ],
        [
          100000,
          0.22
        ],
        [
          250000,
          0.2
        ],
        [
          500000,
          0.18
        ],
        [
          1000000,
          0.16
        ],
        [
          2500000,
          0.14
        ],
        [
          5000000,
          0.12
        ],
        [
          10000000,
          0.1
        ]
      ],
      "fees_maker": [
        [
          0,
          0.16
        ],
        [
          50000,
          0.14
        ],
        [
          100000,
          0.12
        ],
        [
          250000,
          0.1
        ],
        [
          500000,
          0.08
        ],
        [
          1000000,
          0.06
        ],
        [
          2500000,
          0.04
        ],
        [
          5000000,
          0.02
        ],
        [
          10000000,
          0
        ]
      ],
      "fee_volume_currency": "ZUSD",
      "margin_call": 80,
      "margin_stop": 40,
      "ordermin": "10"
    }
  }
}
EOL;

        $response = $this->createClient(
            'https://api.kraken.com/0/public/AssetPairs?pair=XXBTCZUSD%2CXETHXXBT%2CDOTUSDT%2CXXLMZUSD', $json
        )->getTradableAssetPairs(new AssetPair('XXBTCZUSD', 'XETHXXBT', ['DOTUSDT', 'XXLMZUSD']));

        $this->assertEquals('DOTUSDT', $response['DOTUSDT']->altname);
        $this->assertEquals('DOT/USDT', $response['DOTUSDT']->wsname);
        $this->assertEquals('currency', $response['DOTUSDT']->classBase);
        $this->assertEquals('DOT', $response['DOTUSDT']->base);
        $this->assertEquals('currency', $response['DOTUSDT']->classQuote);
        $this->assertEquals('USDT', $response['DOTUSDT']->quote);
        $this->assertEquals(4, $response['DOTUSDT']->pairDecimals);
        $this->assertEquals(8, $response['DOTUSDT']->lotDecimals);
        $this->assertEquals(1, $response['DOTUSDT']->lotMultiplier);
        $this->assertEquals([], $response['DOTUSDT']->leverageBuy);
        $this->assertEquals([], $response['DOTUSDT']->leverageSell);
        $this->assertEquals(0, $response['DOTUSDT']->fees[0]->getVolume());
        $this->assertEquals(0.26, $response['DOTUSDT']->fees[0]->getPercentFee());
        $this->assertEquals(50000, $response['DOTUSDT']->fees[1]->getVolume());
        $this->assertEquals(0.24, $response['DOTUSDT']->fees[1]->getPercentFee());
        $this->assertEquals(0, $response['DOTUSDT']->feesMaker[0]->getVolume());
        $this->assertEquals(0.16, $response['DOTUSDT']->feesMaker[0]->getPercentFee());
        $this->assertEquals(50000, $response['DOTUSDT']->feesMaker[1]->getVolume());
        $this->assertEquals(0.14, $response['DOTUSDT']->feesMaker[1]->getPercentFee());
        $this->assertEquals('ZUSD', $response['DOTUSDT']->feeVolumeCurrency);
        $this->assertEquals(80, $response['DOTUSDT']->marginCall);
        $this->assertEquals(40, $response['DOTUSDT']->marginStop);
        $this->assertEquals("0.2", $response['DOTUSDT']->ordermin);


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
        $this->assertEquals([2, 3, 4, 5], $response['XETHXXBT']->leverageSell);
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
        $this->assertEquals("0.004", $response['XETHXXBT']->ordermin);


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
        $this->assertEquals([2, 3, 4, 5], $response['XXBTZUSD']->leverageSell);
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
        $this->assertEquals("0.0001", $response['XXBTZUSD']->ordermin);


        $this->assertEquals('XLMUSD', $response['XXLMZUSD']->altname);
        $this->assertEquals('XLM/USD', $response['XXLMZUSD']->wsname);
        $this->assertEquals('currency', $response['XXLMZUSD']->classBase);
        $this->assertEquals('XXLM', $response['XXLMZUSD']->base);
        $this->assertEquals('currency', $response['XXLMZUSD']->classQuote);
        $this->assertEquals('ZUSD', $response['XXLMZUSD']->quote);
        $this->assertEquals(6, $response['XXLMZUSD']->pairDecimals);
        $this->assertEquals(8, $response['XXLMZUSD']->lotDecimals);
        $this->assertEquals(1, $response['XXLMZUSD']->lotMultiplier);
        $this->assertEquals([2], $response['XXLMZUSD']->leverageBuy);
        $this->assertEquals([2], $response['XXLMZUSD']->leverageSell);
        $this->assertEquals(0, $response['XXLMZUSD']->fees[0]->getVolume());
        $this->assertEquals(0.26, $response['XXLMZUSD']->fees[0]->getPercentFee());
        $this->assertEquals(50000, $response['XXLMZUSD']->fees[1]->getVolume());
        $this->assertEquals(0.24, $response['XXLMZUSD']->fees[1]->getPercentFee());
        $this->assertEquals(0, $response['XXLMZUSD']->feesMaker[0]->getVolume());
        $this->assertEquals(0.16, $response['XXLMZUSD']->feesMaker[0]->getPercentFee());
        $this->assertEquals(50000, $response['XXLMZUSD']->feesMaker[1]->getVolume());
        $this->assertEquals(0.14, $response['XXLMZUSD']->feesMaker[1]->getPercentFee());
        $this->assertEquals('ZUSD', $response['XXLMZUSD']->feeVolumeCurrency);
        $this->assertEquals(80, $response['XXLMZUSD']->marginCall);
        $this->assertEquals(40, $response['XXLMZUSD']->marginStop);
        $this->assertEquals("10", $response['XXLMZUSD']->ordermin);
    }
}
