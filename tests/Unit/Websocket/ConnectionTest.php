<?php
declare(strict_types=1);

namespace Kraken\Tests\Unit\Websocket;

use Butschster\Kraken\Contracts\PrivateWebsocketEvent;
use Butschster\Kraken\Websocket\Connection;
use Butschster\Kraken\Websocket\Requests\Ping;
use Butschster\Kraken\Websocket\Timer;
use JMS\Serializer\SerializerInterface;
use Kraken\Tests\TestCase;
use Mockery as m;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;

class ConnectionTest extends TestCase
{
    private Connection $connection;
    private \Mockery\LegacyMockInterface|SerializerInterface|\Mockery\MockInterface $serializer;
    private m\LegacyMockInterface|m\MockInterface|WebSocket $conn;
    private m\LegacyMockInterface|LoopInterface|m\MockInterface $loop;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = m::mock(SerializerInterface::class);
        $this->conn = m::mock(WebSocket::class);
        $this->loop = m::mock(LoopInterface::class);

        $this->connection = new Connection(
            $this->serializer,
            $this->conn,
            $this->loop,
        );
    }

    function test_subscribe_on_received_message()
    {
        $message = m::mock(MessageInterface::class);
        $message->shouldReceive('getPayload')->once()->andReturn('test-message');

        $callback = $this->getMockBuilder('NonExistentClass')
            ->setMethods(['__invoke'])
            ->getMock();

        $callback->expects($this->once())->method('__invoke')->with('test-message');

        $this->conn->shouldReceive('on')->once()->withArgs(function (string $event, \Closure $closure) use($message) {
            $closure($message);

            return $event === 'message';
        });

        $this->connection->onMessage($callback);
    }

    function test_adds_timer()
    {
        $event = new Ping();

        $this->serializer->shouldReceive('serialize')
            ->once()
            ->with($event, 'json')
            ->andReturn('json-body');

        $this->loop->shouldReceive('addTimer')
            ->withArgs(function (int $interval, $closure) {
                $closure();
                return $interval === 100;
            });

        $this->conn->shouldReceive('send')->once()->with('json-body');

        $this->connection->addTimer(new Timer(100, $event));

        $this->assertTrue(true);
    }

    function test_adds_periodic_timer()
    {
        $event = new Ping();

        $this->serializer->shouldReceive('serialize')
            ->once()
            ->with($event, 'json')
            ->andReturn('json-body');

        $this->loop->shouldReceive('addPeriodicTimer')
            ->withArgs(function (int $interval, $closure) {
                $closure();
                return $interval === 100;
            });

        $this->conn->shouldReceive('send')->once()->with('json-body');

        $this->connection->addPeriodicTimer(new Timer(100, $event));

        $this->assertTrue(true);
    }

    function test_sends_message()
    {
        $this->conn->shouldReceive('send')->once()->with('test-message');
        $this->connection->sendMessage('test-message');
        $this->assertTrue(true);
    }

    function test_sends_event()
    {
        $event = new Ping();

        $this->serializer->shouldReceive('serialize')
            ->once()
            ->with($event, 'json')
            ->andReturn('json-body');

        $this->conn->shouldReceive('send')->once()->with('json-body');
        $this->connection->sendEvent($event);
        $this->assertTrue(true);
    }

    function test_token_should_be_passed_when_private_event_sent()
    {
        $this->connection->setToken('test-token');

        $event = m::mock(PrivateWebsocketEvent::class);
        $event->shouldReceive('setToken')->with('test-token');

        $this->serializer->shouldReceive('serialize')
            ->once()
            ->with($event, 'json')
            ->andReturn('json-body');

        $this->conn->shouldReceive('send')->once()->with('json-body');
        $this->connection->sendEvent($event);
        $this->assertTrue(true);
    }

    function test_token_should_not_be_passed_when_private_event_sent_but_token_is_null()
    {
        $event = m::mock(PrivateWebsocketEvent::class);
        $event->shouldNotReceive('setToken');

        $this->serializer->shouldReceive('serialize')
            ->once()
            ->with($event, 'json')
            ->andReturn('json-body');

        $this->conn->shouldReceive('send')->once()->with('json-body');
        $this->connection->sendEvent($event);
        $this->assertTrue(true);
    }
}