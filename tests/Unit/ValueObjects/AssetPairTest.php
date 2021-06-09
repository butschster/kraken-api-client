<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\AssetPair;
use Kraken\Tests\TestCase;

class AssetPairTest extends TestCase
{
    private AssetPair $pair;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pair = new AssetPair('BTC', 'USD');
    }

    function test_gets_asset1()
    {
        $this->assertEquals('BTC', $this->pair->getAsset1());
    }

    function test_gets_asset2()
    {
        $this->assertEquals('USD', $this->pair->getAsset2());
    }

    function test_converts_to_string()
    {
        $this->assertEquals('BTC,USD', (string) $this->pair);
    }
}