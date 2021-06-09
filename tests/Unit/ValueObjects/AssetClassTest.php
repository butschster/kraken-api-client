<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\AssetClass;
use Kraken\Tests\TestCase;

class AssetClassTest extends TestCase
{
    function test_created_currency_class()
    {
        $class = AssetClass::currency();
        $this->assertEquals(AssetClass::currency, $class->value());
    }
}