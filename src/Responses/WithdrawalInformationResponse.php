<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\WithdrawalInformation;

class WithdrawalInformationResponse extends AbstractResponse
{
    public ?WithdrawalInformation $result = null;
}
