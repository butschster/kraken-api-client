<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket\Requests;

class Ping extends AbstractEvent
{
    public string $event = 'ping';
}