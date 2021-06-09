<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\TradeBalance;

class TradeBalanceResponse extends AbstractResponse
{
    public ?TradeBalance $result = null;
}