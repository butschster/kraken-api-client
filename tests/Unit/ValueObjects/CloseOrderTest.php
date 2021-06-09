<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\ValueObjects;

use Butschster\Kraken\ValueObjects\CloseOrder;
use Butschster\Kraken\ValueObjects\OrderType;
use Kraken\Tests\TestCase;

class CloseOrderTest extends TestCase
{
    private CloseOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = new CloseOrder(
            OrderType::limit(),
            '1.0000',
            '2.0000',
        );
    }

    function test_gets_order_type()
    {
        $this->assertEquals(OrderType::limit, $this->order->orderType()->value());
    }

    function test_gets_price()
    {
        $this->assertEquals('1.0000', $this->order->price());
    }

    function test_gets_secondary_price()
    {
        $this->assertEquals('2.0000', $this->order->secondaryPrice());
    }
}