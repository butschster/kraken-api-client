<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\OrderBook;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class Orders
{
    /**
     * Ask side array of entries [<price>, <volume>, <timestamp>]
     * @Type("array")
     * @Accessor(setter="setAsks")
     * @var Order[]
     */
    public array $asks = [];

    /**
     * Bid side array of entries [<price>, <volume>, <timestamp>]
     * @Type("array")
     * @Accessor(setter="setBids")
     * @var Order[]
     */
    public array $bids = [];

    public function setAsks(array $orders): void
    {
        $this->asks = array_map(fn(array $order) => new Order(...$order), $orders);
    }

    public function setBids(array $orders): void
    {
        $this->bids = array_map(fn(array $order) => new Order(...$order), $orders);
    }
}