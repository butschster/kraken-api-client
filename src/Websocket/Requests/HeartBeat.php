<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket\Requests;

class HeartBeat extends AbstractEvent
{
    public string $event = 'heartbeat';
}