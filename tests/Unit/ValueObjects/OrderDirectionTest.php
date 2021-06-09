<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\OrderDirection;
use Kraken\Tests\TestCase;

class OrderDirectionTest extends TestCase
{
    function test_creates_sell_order()
    {
        $order = OrderDirection::sell();

        $this->assertEquals(OrderDirection::sell, $order->value());
    }

    function test_creates_buy_order()
    {
        $order = OrderDirection::buy();

        $this->assertEquals(OrderDirection::buy, $order->value());
    }
}