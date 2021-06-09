<?php
declare(strict_types=1);

namespace Butschster\Kraken\Websocket\Requests;

use JMS\Serializer\Annotation\Type;

class Subscribe extends AbstractEvent
{
    public string $event = 'subscribe';

    /**
     * Optional - Array of currency pairs. Format of each pair is "A/B", where A and B are ISO 4217-A3 for
     * standardized assets and popular unique symbol if not standardized.
     * @Type("array<string>")
     */
    public array $pair = [];

    /**
     * @param array<string> $pair
     */
    public function __construct(string $name, array $pair = [], ?int $depth = null, ?int $interval = null)
    {
        $this->pair = $pair;
        $this->subscription['name'] = $name;

        if ($depth) {
            $this->subscription['depth'] = $depth;
        }

        if ($interval) {
            $this->subscription['interval'] = $interval;
        }
    }
}