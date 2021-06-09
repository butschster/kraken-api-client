<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\TickerInformation;

class Trades
{
    public function __construct(private int $today, private int $last24Hours)
    {
    }

    public function getToday(): int
    {
        return $this->today;
    }

    public function getLast24Hours(): int
    {
        return $this->last24Hours;
    }
}