<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\Orders\ClosedOrders;

class ClosedOrdersResponse extends AbstractResponse
{
    public ?ClosedOrders $result = null;
}