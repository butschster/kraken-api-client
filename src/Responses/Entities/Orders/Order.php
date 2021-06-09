<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\Orders;

use Brick\Math\BigDecimal;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;

class Order
{
    /**
     * Referral order transaction ID that created this order
     * @Type("string")
     * @SerializedName("refid")
     */
    public ?string $refId = null;

    /**
     * User reference id
     * @Type("int")
     * @SerializedName("userref")
     */
    public int $userRef = 0;

    /**
     * Status of order
     *      - pending = order pending book entry
     *      - open = open order
     *      - closed = closed order
     *      - canceled = order canceled
     *      - expired = order expired
     *
     * @Type("string")
     */
    public string $status;

    /**
     * Change status reason
     * @Type("string")
     */
    public ?string $reason = null;

    /**
     * Unix timestamp of when order was placed
     * @Type("float")
     * @SerializedName("opentm")
     */
    public float $openTimestamp = 0;

    /**
     * Unix timestamp of when order was closed
     * @Type("float")
     * @SerializedName("closetm")
     */
    public float $closeTimestamp = 0;

    /**
     * Unix timestamp of order start time (or 0 if not set)
     * @Type("float")
     * @SerializedName("starttm")
     */
    public float $startTimestamp = 0;

    /**
     * Unix timestamp of order end time (or 0 if not set)
     * @Type("float")
     * @SerializedName("expiretm")
     */
    public float $expireTimestamp = 0;

    /**
     * Order description info
     * @SerializedName("descr")
     */
    public OrderDescription $description;

    /**
     * Volume of order (base currency)
     * @Type("string")
     * @Accessor(setter="setVolume")
     * @SerializedName("vol")
     */
    public BigDecimal $volume;

    /**
     * Volume executed (base currency)
     * @Type("string")
     * @Accessor(setter="setVolumeExecuted")
     * @SerializedName("vol_exec")
     */
    public BigDecimal $volumeExecuted;

    /**
     * Total cost (quote currency unless)
     * @Type("string")
     * @Accessor(setter="setCost")
     */
    public BigDecimal $cost;

    /**
     * Total fee (quote currency)
     * @Type("string")
     * @Accessor(setter="setFee")
     */
    public BigDecimal $fee;

    /**
     * Average price (quote currency)
     * @Type("string")
     * @Accessor(setter="setPrice")
     */
    public BigDecimal $price;

    /**
     * Stop price (quote currency)
     * @Type("string")
     * @Accessor(setter="setStopPrice")
     * @SerializedName("stopprice")
     */
    public BigDecimal $stopPrice;

    /**
     * Triggered limit price (quote currency, when limit based order type triggered)
     * @Type("string")
     * @Accessor(setter="setLimitPrice")
     * @SerializedName("limitprice")
     */
    public BigDecimal $limitPrice;

    /**
     * List of miscellaneous info
     * @Type("string")
     * @Accessor(setter="setMiscellaneous")
     * @SerializedName("misc")
     */
    public array $miscellaneous = [];

    /**
     * List of order flags
     * @Type("string")
     * @Accessor(setter="setFlags")
     * @SerializedName("oflags")
     */
    public array $flags = [];

    /**
     * List of trade IDs related to order (if trades info requested and data available)
     * @Type("array<string>")
     */
    public array $trades = [];

    public function setVolume(string $volume): void
    {
        $this->volume = BigDecimal::of($volume);
    }

    public function setVolumeExecuted(string $volume): void
    {
        $this->volumeExecuted = BigDecimal::of($volume);
    }

    public function setCost(string $cost): void
    {
        $this->cost = BigDecimal::of($cost);
    }

    public function setFee(string $fee): void
    {
        $this->fee = BigDecimal::of($fee);
    }

    public function setPrice(string $price): void
    {
        $this->price = BigDecimal::of($price);
    }

    public function setStopPrice(string $price): void
    {
        $this->stopPrice = BigDecimal::of($price);
    }

    public function setLimitPrice(string $price): void
    {
        $this->limitPrice = BigDecimal::of($price);
    }

    public function setMiscellaneous(string $miscellaneous): void
    {
        $this->miscellaneous = array_filter(explode(',', $miscellaneous));
    }

    public function setFlags(string $flags): void
    {
        $this->flags = array_filter(explode(',', $flags));
    }
}