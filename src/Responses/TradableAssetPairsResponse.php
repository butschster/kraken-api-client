<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;
use JMS\Serializer\Annotation\Type;

class TradableAssetPairsResponse extends AbstractResponse
{
    /** @Type("array<string, Butschster\Kraken\Responses\Entities\TradableAsset>") */
    public ?array $result = null;
}