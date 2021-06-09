<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\AddOrder;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class OrderAdded
{
    /**
     * Order description info
     * @SerializedName("descr")
     */
    public Description $description;

    /**
     * Transaction IDs for order
     * @Type("array<string>")
     * @SerializedName("txid")
     */
    public array $txId = [];
}