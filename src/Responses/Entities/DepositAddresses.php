<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

class DepositAddresses
{
    /**
     * Deposit Address
     * @Type("string")
     */
    public string $address;

    /**
     * Expiration time in unix timestamp, or 0 if not expiring
     * @SerializedName("expiretm")
     * @Type("int")
     */
    public int $expireTimestamp = 0;

    /**
     * Whether or not address has ever been used
     * @Type("bool")
     */
    public bool $new = false;
}
