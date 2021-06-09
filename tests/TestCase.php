<?php
declare(strict_types=1);

namespace Kraken\Tests;

use Butschster\Kraken\Client;
use Butschster\Kraken\Contracts\NonceGenerator;
use Butschster\Kraken\Serializer\SerializerFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Mockery as m;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function createClient(string $urlWithQueryString, string $json): Client
    {
        $http = m::mock(ClientInterface::class);

        $http->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $url, array $params) use ($urlWithQueryString) {
                if (!empty($params['form_params'])) {
                    $url = $url . '?' . http_build_query($params['form_params']);
                }

                $this->assertEquals($urlWithQueryString, $url);

                return true;
            })
            ->andReturn(new Response(200, [], $json));

        $nonce = m::mock(NonceGenerator::class);
        $nonce->shouldReceive('generate')->andReturn(1234567890);

        return new Client(
            $http,
            $nonce,
            (new SerializerFactory())->build(),
            'api-key',
            'api-secret'
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }
}
