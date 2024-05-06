<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use JMS\Serializer\Annotation\Type;

class DepositAddressesResponse extends AbstractResponse
{
    #[Type("array<string, Butschster\Kraken\Responses\Entities\DepositAddresses>")]
    public array $result = [];
}
