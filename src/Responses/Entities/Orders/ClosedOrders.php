<?php

declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\Orders;

use JMS\Serializer\Annotation\Type;

class ClosedOrders
{
    /**
     * Closed Orders
     * @var \Butschster\Kraken\Responses\Entities\Orders\Order[]
     */
    #[Type("array<string, Butschster\Kraken\Responses\Entities\Orders\Order>")]
    public array $closed = [];

    /**
     * Amount of available order info matching criteria
     */
    #[Type("int")]
    public int $count = 0;
}
