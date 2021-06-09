<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\TradableInfo;
use Kraken\Tests\TestCase;

class TradableInfoTest extends TestCase
{
    function test_creates_info()
    {
        $info = TradableInfo::info();

        $this->assertEquals('info', $info->value());
    }

    function test_creates_leverage()
    {
        $info = TradableInfo::leverage();

        $this->assertEquals('leverage', $info->value());
    }

    function test_creates_fees()
    {
        $info = TradableInfo::fees();

        $this->assertEquals('fees', $info->value());
    }

    function test_creates_margin()
    {
        $info = TradableInfo::margin();

        $this->assertEquals('margin', $info->value());
    }
}