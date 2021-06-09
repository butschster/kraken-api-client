<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\WebsocketToken;

class GetWebSocketsTokenResponse extends AbstractResponse
{
    public ?WebsocketToken $result = null;
}