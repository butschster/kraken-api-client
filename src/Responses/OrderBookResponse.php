<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class OrderBookResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\OrderBook\Orders>") */
    public ?array $result = null;
}