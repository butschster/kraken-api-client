<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Brick\Math\BigDecimal;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;

class TradeBalance
{
    /**
     * Equivalent balance (combined balance of all currencies)
     * @SerializedName("eb")
     * @Accessor(setter="setEquivalentBalance")
     * @Type("string")
     */
    public BigDecimal $equivalentBalance;

    /**
     * Trade balance (combined balance of all equity currencies)
     * @SerializedName("tb")
     * @Accessor(setter="setTradeBalance")
     * @Type("string")
     */
    public BigDecimal $tradeBalance;

    /**
     * Margin amount of open positions
     * @SerializedName("m")
     * @Accessor(setter="setMarginAmount")
     * @Type("string")
     */
    public BigDecimal $marginAmount;

    /**
     * Unrealized net profit/loss of open positions
     * @SerializedName("n")
     * @Accessor(setter="setNet")
     * @Type("string")
     */
    public BigDecimal $net;

    /**
     * Cost basis of open positions
     * @SerializedName("c")
     * @Accessor(setter="setCost")
     * @Type("string")
     */
    public BigDecimal $cost;

    /**
     * Current floating valuation of open positions
     * @SerializedName("v")
     * @Accessor(setter="setValuation")
     * @Type("string")
     */
    public BigDecimal $valuation;

    /**
     * Equity: trade balance + unrealized net profit/loss
     * @SerializedName("e")
     * @Accessor(setter="setEquity")
     * @Type("string")
     */
    public BigDecimal $equity;

    /**
     * Free margin: Equity - initial margin (maximum margin available to open new positions)
     * @SerializedName("mf")
     * @Accessor(setter="setFreeMargin")
     * @Type("string")
     */
    public BigDecimal $freeMargin;

    /**
     * Margin level: (equity / initial margin) * 100
     * @SerializedName("ml")
     * @Accessor(setter="setMarginLevel")
     * @Type("string")
     */
    public BigDecimal $marginLevel;

    public function setEquivalentBalance(string $balance): void
    {
        $this->equivalentBalance = BigDecimal::of($balance);
    }

    public function setTradeBalance(string $balance): void
    {
        $this->tradeBalance = BigDecimal::of($balance);
    }

    public function setMarginAmount(string $amount): void
    {
        $this->marginAmount = BigDecimal::of($amount);
    }

    public function setNet(string $amount): void
    {
        $this->net = BigDecimal::of($amount);
    }

    public function setCost(string $cost): void
    {
        $this->cost = BigDecimal::of($cost);
    }

    public function setValuation(string $amount): void
    {
        $this->valuation = BigDecimal::of($amount);
    }

    public function setEquity(string $amount): void
    {
        $this->equity = BigDecimal::of($amount);
    }

    public function setFreeMargin(string $amount): void
    {
        $this->freeMargin = BigDecimal::of($amount);
    }

    public function setMarginLevel(string $amount): void
    {
        $this->marginLevel = BigDecimal::of($amount);
    }
}