<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class AssetInfoResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\AssetInfo>") */
    public ?array $result = null;
}