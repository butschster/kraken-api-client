<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class DepositMethodsResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\DepositMethods>") */
    public array $result = [];
}
