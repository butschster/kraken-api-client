<?php
declare(strict_types=1);

namespace Butschster\Kraken\Contracts;

use Closure;

interface WebsocketClient
{
    /**
     * Connect to a private server
     * @param string $token Websocket token
     * @param Closure $callback On connect callback
     */
    public function connectToPrivateServer(string $token, Closure $callback): void;

    /**
     * Connect to a public server
     * @param Closure $callback On connect callback
     */
    public function connectToPublicServer(Closure $callback): void;
}