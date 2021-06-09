<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class QueryOrdersResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\Orders\Order>") */
    public ?array $result = null;
}