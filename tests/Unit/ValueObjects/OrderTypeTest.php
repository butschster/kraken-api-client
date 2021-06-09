<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\OrderType;
use Kraken\Tests\TestCase;

class OrderTypeTest extends TestCase
{
    function test_creates_market_type()
    {
        $type = OrderType::market();

        $this->assertEquals(OrderType::market, $type->value());
    }

    function test_creates_limit_type()
    {
        $type = OrderType::limit();

        $this->assertEquals(OrderType::limit, $type->value());
    }

    function test_creates_stop_loss_type()
    {
        $type = OrderType::stopLoss();

        $this->assertEquals(OrderType::stopLoss, $type->value());
    }

    function test_creates_take_profit_type()
    {
        $type = OrderType::takeProfit();

        $this->assertEquals(OrderType::takeProfit, $type->value());
    }

    function test_creates_stop_loss_limit_type()
    {
        $type = OrderType::stopLossLimit();

        $this->assertEquals(OrderType::stopLossLimit, $type->value());
    }

    function test_creates_take_profit_limit_type()
    {
        $type = OrderType::takeProfitLimit();

        $this->assertEquals(OrderType::takeProfitLimit, $type->value());
    }

    function test_creates_settle_position_type()
    {
        $type = OrderType::settlePosition();

        $this->assertEquals(OrderType::settlePosition, $type->value());
    }
}