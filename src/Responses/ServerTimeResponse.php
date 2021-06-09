<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\ServerTime;

class ServerTimeResponse extends AbstractResponse
{
    public ?ServerTime $result = null;
}