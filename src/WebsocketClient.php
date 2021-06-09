<?php
declare(strict_types=1);

namespace Butschster\Kraken;

use Butschster\Kraken\Websocket\Connection;
use Closure;
use JMS\Serializer\SerializerInterface;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use Throwable;

class WebsocketClient implements Contracts\WebsocketClient
{
    private const WS_SERVER = 'wss://ws.kraken.com';
    private const WS_PRIVATE_SERVER = 'wss://ws-auth.kraken.com';

    private array $onConnectCallback = [];
    private array $onMessageCallback = [];
    private array $onCloseCallback = [];
    private array $onFailureCallback = [];

    public function __construct(
        private SerializerInterface $serializer,
        private LoopInterface $loop,
        private array $headers = []
    )
    {
    }

    public function connectToPrivateServer(string $token, Closure $callback): void
    {
        $this->onConnectCallback($callback);
        $this->connect(self::WS_PRIVATE_SERVER, $token);
    }

    public function connectToPublicServer(Closure $callback): void
    {
        $this->onConnectCallback($callback);
        $this->connect(self::WS_SERVER);
    }

    private function connect(string $server, ?string $token = null): void
    {
        $connector = new Connector($this->loop);

        try {
            $connector($server, [], $this->headers)->then(
                $this->onConnect($token),
                $this->onFailure()
            );
        } catch (Throwable $e) {
            foreach ($this->onFailureCallback as $callback) {
                $callback($e);
            }

            $this->loop->stop();
        }

        $this->loop->run();
    }

    private function onConnect(LoopInterface $loop, ?string $token): Closure
    {
        return function (WebSocket $conn) use ($loop, $token) {

            $connection = new Connection($this->serializer, $conn, $loop, $token);

            foreach ($this->onConnectCallback as $callback) {
                $callback($connection);
            }

            $conn->on('message', function (MessageInterface $msg) use ($conn, $loop) {
                foreach ($this->onMessageCallback as $callback) {
                    $callback($conn, $msg->getPayload());
                }
            });

            foreach ($this->onCloseCallback as $callback) {
                $conn->on('close', $callback);
            }
        };
    }

    private function onFailure(LoopInterface $loop): Closure
    {
        return function (Throwable $e) use ($loop) {
            foreach ($this->onFailureCallback as $callback) {
                $callback($e);
            }

            $loop->stop();
        };
    }

    public function onConnectCallback(Closure $callback): self
    {
        $this->onConnectCallback[] = $callback;
        return $this;
    }

    public function onMessageCallback(Closure $callback): self
    {
        $this->onMessageCallback[] = $callback;
        return $this;
    }

    public function onCloseCallback(Closure $callback): self
    {
        $this->onCloseCallback[] = $callback;
        return $this;
    }

    public function onFailureCallback(Closure $callback): self
    {
        $this->onFailureCallback[] = $callback;
        return $this;
    }
}