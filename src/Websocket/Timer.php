<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket;

use Butschster\Kraken\Contracts\WebsocketEvent;
use Closure;

class Timer
{
    public function __construct(
        private int $interval,
        private WebsocketEvent|Closure $event
    )
    {
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function getEvent(): WebsocketEvent|Closure
    {
        return $this->event;
    }
}