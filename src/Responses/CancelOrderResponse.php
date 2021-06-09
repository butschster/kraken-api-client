<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\CancelOrder;

class CancelOrderResponse extends AbstractResponse
{
    public ?CancelOrder $result = null;
}