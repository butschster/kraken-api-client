<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

class Fee
{
    public function __construct(private int $volume, private float $percentFee)
    {
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    /**
     * @return float
     */
    public function getPercentFee(): float
    {
        return $this->percentFee;
    }
}