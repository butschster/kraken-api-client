<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket\Requests;

use Butschster\Kraken\Contracts\WebsocketEvent;

class AbstractEvent implements WebsocketEvent
{
    public ?array $subscription = null;

    public function setToken(string $token): void
    {
        if (!$this->subscription) {
            $this->subscription = [];
        }

        $this->subscription['token'] = $token;
    }
}