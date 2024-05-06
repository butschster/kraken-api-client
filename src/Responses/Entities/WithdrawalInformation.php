<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Brick\Math\BigDecimal;
use JMS\Serializer\Annotation\Type;

class WithdrawalInformation
{
    /**
     * Name of the withdrawal method that will be used
     */
    public string $method;

    /**
     * Maximum net amount that can be withdrawn right now
     */
    #[Type(BigDecimal::class)]
    public BigDecimal $limit;

    /**
     * Net amount that will be sent, after fees
     */
    #[Type(BigDecimal::class)]
    public BigDecimal $amount;

    /**
     * Amount of fees that will be paid
     */
    #[Type(BigDecimal::class)]
    public BigDecimal $fee;
}
