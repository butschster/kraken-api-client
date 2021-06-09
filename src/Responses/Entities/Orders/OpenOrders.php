<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\Orders;

use JMS\Serializer\Annotation\Type;

class OpenOrders
{
    /**
     * @Type("array<string, Butschster\Kraken\Responses\Entities\Orders\Order>")
     */
    public array $open = [];
}