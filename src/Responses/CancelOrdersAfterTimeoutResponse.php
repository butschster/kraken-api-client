<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\CancelOrdersAfterTimeout;

class CancelOrdersAfterTimeoutResponse extends AbstractResponse
{
    public ?CancelOrdersAfterTimeout $result = null;
}