<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class TickerInformationResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\TickerInformation>") */
    public ?array $result = null;
}