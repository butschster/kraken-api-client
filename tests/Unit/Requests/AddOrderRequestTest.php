<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Requests;

use Brick\Math\BigDecimal;
use Butschster\Kraken\Requests\AddOrderRequest;
use Butschster\Kraken\ValueObjects\CloseOrder;
use Butschster\Kraken\ValueObjects\OrderDirection;
use Butschster\Kraken\ValueObjects\OrderType;
use Kraken\Tests\TestCase;

class AddOrderRequestTest extends TestCase
{
    private AddOrderRequest $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = new AddOrderRequest(
            OrderType::market(),
            OrderDirection::buy(),
            'XXBTZUSD'
        );
    }

    function test_gets_pair()
    {
        $this->assertEquals('XXBTZUSD', $this->order->pair());
    }

    function test_gets_order_type()
    {
        $this->assertEquals('market', $this->order->orderType()->value());
    }

    function test_gets_direction()
    {
        $this->assertEquals('buy', $this->order->direction()->value());
    }

    function test_sets_user_ref()
    {
        $this->assertNull($this->order->userRef());

        $this->order->setUserRef(100);

        $this->assertEquals(100, $this->order->userRef());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'userref' => 100
        ], $this->order->toArray());
    }

    function test_sets_volume()
    {
        $this->assertNull($this->order->volume());

        $this->order->setVolume(BigDecimal::of('0.0001'));

        $this->assertEquals('0.0001', (string)$this->order->volume());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'volume' => '0.0001'
        ], $this->order->toArray());
    }

    function test_sets_close_order()
    {
        $this->assertNull($this->order->close());

        $this->order->setCloseOrder($order = new CloseOrder(
            OrderType::limit(), '1.123123', '2.123123'
        ));

        $this->assertEquals($order, $this->order->close());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'close' => [
                'ordertype' => 'limit',
                'price' => '1.123123',
                'price2' => '2.123123',
            ]
        ], $this->order->toArray());
    }

    function test_sets_price()
    {
        $this->assertNull($this->order->price());

        $this->order->setPrice('0.0001');

        $this->assertEquals('0.0001', (string)$this->order->price());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'price' => '0.0001'
        ], $this->order->toArray());
    }

    function test_sets_secondary_price()
    {
        $this->assertNull($this->order->secondaryPrice());

        $this->order->setSecondaryPrice('0.0001');

        $this->assertEquals('0.0001', (string)$this->order->secondaryPrice());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'price2' => '0.0001'
        ], $this->order->toArray());
    }

    function test_sets_leverage()
    {
        $this->assertNull($this->order->leverage());

        $this->order->setLeverage('none');

        $this->assertEquals('none', (string)$this->order->leverage());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'leverage' => 'none'
        ], $this->order->toArray());
    }

    function test_sets_flags()
    {
        $this->assertNull($this->order->flags());

        $this->order->setFlags(['flag1', 'flag2']);

        $this->assertEquals(['flag1', 'flag2'], $this->order->flags());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'oflags' => 'flag1,flag2'
        ], $this->order->toArray());
    }

    function test_agrees_trading()
    {
        $this->assertFalse($this->order->isTradingAgreed());

        $this->order->agreeTrading();

        $this->assertTrue($this->order->isTradingAgreed());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'trading_agreement' => 'agreed'
        ], $this->order->toArray());
    }

    function test_only_validation()
    {
        $this->assertFalse($this->order->isOnlyValidate());

        $this->order->onlyValidate();

        $this->assertTrue($this->order->isOnlyValidate());

        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
            'validate' => true
        ], $this->order->toArray());
    }

    function test_converts_to_array()
    {
        $this->assertEquals([
            'ordertype' => 'market',
            'type' => 'buy',
            'pair' => 'XXBTZUSD',
        ], $this->order->toArray());
    }
}