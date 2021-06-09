<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\Orders\OpenOrders;

class OpenOrdersResponse extends AbstractResponse
{
    public ?OpenOrders $result = null;
}