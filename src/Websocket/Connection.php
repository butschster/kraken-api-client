<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket;

use Butschster\Kraken\Contracts\PrivateWebsocketEvent;
use Butschster\Kraken\Contracts\WebsocketEvent;
use Closure;
use JMS\Serializer\SerializerInterface;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;

class Connection
{
    public function __construct(
        private SerializerInterface $serializer,
        private WebSocket $conn,
        private LoopInterface $loop,
        private ?string $token = null
    )
    {
    }

    /**
     * Set websocket token
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Subscribe on received message from the server
     * @param callable $callback
     */
    public function onMessage(callable $callback): void
    {
        $this->conn->on('message', function (MessageInterface $msg) use ($callback) {
            $callback($msg->getPayload());
        });
    }

    /**
     * Add timer to be invoked once after the given interval.
     */
    public function addTimer(Timer $timer): void
    {
        $this->loop->addTimer($timer->getInterval(), function () use ($timer) {
            if ($timer->getEvent() instanceof WebsocketEvent) {
                $this->sendEvent($timer->getEvent());
            } else {
                $timer->getEvent()($this);
            }
        });
    }

    /**
     * Add timer to be invoked repeatedly after the given interval.
     */
    public function addPeriodicTimer(Timer $timer): void
    {
        $this->loop->addPeriodicTimer($timer->getInterval(), function () use ($timer) {
            if ($timer->getEvent() instanceof WebsocketEvent) {
                $this->sendEvent($timer->getEvent());
            } else {
                $timer->getEvent()($this);
            }
        });
    }

    /**
     * Send a message to the server
     */
    public function sendMessage(string $message): void
    {
        $this->conn->send($message);
    }

    /**
     * Send an Event to the server
     */
    public function sendEvent(WebsocketEvent $event): void
    {
        if ($this->token && $event instanceof PrivateWebsocketEvent) {
            $event->setToken($this->token);
        }

        $this->conn->send($this->serializer->serialize($event, 'json'));
    }

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }
}