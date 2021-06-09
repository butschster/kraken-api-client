<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\Orders;

use Brick\Math\BigDecimal;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;

class OrderDescription
{
    /**
     * Asset pair
     * @Type("string")
     */
    public string $pair;

    /**
     * Type of order (buy/sell)
     * @Type("string")
     */
    public string $type;

    /**
     * Order type
     * @Type("string")
     * @SerializedName("ordertype")
     */
    public string $orderType;

    /**
     * Primary price
     * @Type("string")
     * @Accessor(setter="setPrice")
     */
    public BigDecimal $price;

    /**
     * Secondary price
     * @Type("string")
     * @SerializedName("price2")
     * @Accessor(setter="setSecondaryPrice")
     */
    public BigDecimal $secondaryPrice;

    /**
     * Amount of leverage
     * @Type("string")
     */
    public string $leverage;

    /**
     * Order description
     * @Type("string")
     */
    public string $order;

    /**
     * Conditional close order description (if conditional close set)
     * @Type("string")
     * @SerializedName("close")
     */
    public string $close = '';

    public function setPrice(string $price): void
    {
        $this->price = BigDecimal::of($price);
    }

    public function setSecondaryPrice(string $price): void
    {
        $this->secondaryPrice = BigDecimal::of($price);
    }
}