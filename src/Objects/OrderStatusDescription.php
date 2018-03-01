<?php

namespace Butschster\Kraken\Objects;

class OrderStatusDescription
{
    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $close;

    /**
     * @param string $order
     * @param string|null $close
     */
    public function __construct(string $order, string $close = null)
    {
        $this->order = $order;
        $this->close = $close;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getClose()
    {
        return $this->close;
    }
}