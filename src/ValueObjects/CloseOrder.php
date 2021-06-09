<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

class CloseOrder
{
    public function __construct(
        private OrderType $orderType,
        private string $price,
        private string $secondaryPrice
    )
    {
    }

    /**
     * Conditional close order type.
     * Note: Conditional close orders are triggered by execution of the primary order in the same quantity and opposite
     * direction, but once triggered are independent orders that may reduce or increase net position.
     */
    public function orderType(): OrderType
    {
        return $this->orderType;
    }


    /**
     * Conditional close order price
     */
    public function price(): string
    {
        return $this->price;
    }

    /**
     * Conditional close order price2
     */
    public function secondaryPrice(): string
    {
        return $this->secondaryPrice;
    }
}