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
     * @Type("BigDecimal")
     */
    public BigDecimal $equivalentBalance;

    /**
     * Trade balance (combined balance of all equity currencies)
     * @SerializedName("tb")
     * @Type("BigDecimal")
     */
    public BigDecimal $tradeBalance;

    /**
     * Margin amount of open positions
     * @SerializedName("m")
     * @Type("BigDecimal")
     */
    public BigDecimal $marginAmount;

    /**
     * Unrealized net profit/loss of open positions
     * @SerializedName("n")
     * @Type("BigDecimal")
     */
    public BigDecimal $net;

    /**
     * Cost basis of open positions
     * @SerializedName("c")
     * @Type("BigDecimal")
     */
    public BigDecimal $cost;

    /**
     * Current floating valuation of open positions
     * @SerializedName("v")
     * @Type("BigDecimal")
     */
    public BigDecimal $valuation;

    /**
     * Equity: trade balance + unrealized net profit/loss
     * @SerializedName("e")
     * @Type("BigDecimal")
     */
    public BigDecimal $equity;

    /**
     * Free margin: Equity - initial margin (maximum margin available to open new positions)
     * @SerializedName("mf")
     * @Type("BigDecimal")
     */
    public BigDecimal $freeMargin;

    /**
     * Margin level: (equity / initial margin) * 100
     * @SerializedName("ml")
     * @Type("BigDecimal")
     */
    public BigDecimal $marginLevel;
}
