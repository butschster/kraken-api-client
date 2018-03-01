<?php

namespace Butschster\Kraken\Objects;

class OrderStatus
{
    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @var OrderStatusDescription
     */
    protected $description;

    /**
     * @param string $transactionId
     * @param array $descriptions
     */
    public function __construct(string $transactionId, array $descriptions = [])
    {
        $this->transactionId = $transactionId;

        $this->description = new OrderStatusDescription(
            $descriptions['order'] ?: null,
            $descriptions['close'] ?: null
        );
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return OrderStatusDescription
     */
    public function getDescription(): OrderStatusDescription
    {
        return $this->description;
    }
}