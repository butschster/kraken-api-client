<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Brick\Math\BigDecimal;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;

class DepositMethods
{
    /**
     * Name of deposit method
     * @Type("string")
     */
    public string $method;

    /**
     * Maximum net amount that can be deposited right now, or false if no limit
     * @Accessor(setter="setLimit")
     * @Type("string")
     */
    public bool|string $limit;

    /**
     * Amount of fees that will be paid
     * @Type("BigDecimal")
     */
    public BigDecimal $fee;

    /**
     * Whether or not method has an address setup fee
     * @SerializedName("address-setup-fee")
     * @Type("string")
     */
    public ?string $addressSetupFee = null;

    /**
     * Whether new addresses can be generated for this method.
     * @SerializedName("gen-address")
     * @Type("bool")
     */
    public bool $generatedAddress;

    public function setLimit(string $limit): void
    {
        if ($limit === '') {
            $limit = false;
        }

        $this->limit = $limit;
    }
}
