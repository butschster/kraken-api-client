<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\SystemStatus;

class SystemStatusResponse extends AbstractResponse
{
    public ?SystemStatus $result = null;
}