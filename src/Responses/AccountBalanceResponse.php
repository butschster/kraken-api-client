<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\AccountBalance;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class AccountBalanceResponse extends AbstractResponse
{
    #[Type("array")]
    #[Accessor(setter: "setBalances")]
    public ?array $result = null;

    public function setBalances(array $assets): void
    {
        foreach ($assets as $asset => $balance) {
            $this->result[$asset] = new AccountBalance($asset, $balance);
        }
    }
}
