<?php
declare(strict_types=1);

namespace Butschster\Kraken\Contracts;

interface PrivateWebsocketEvent extends WebsocketEvent
{
    public function setToken(string $token): void;
}