<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\TickerInformation;

use Brick\Math\BigDecimal;

class Volume
{
    private BigDecimal $today;
    private BigDecimal $last24Hours;

    public function __construct(string $today, string $last24Hours)
    {
        $this->today = BigDecimal::of($today);
        $this->last24Hours = BigDecimal::of($last24Hours);
    }

    public function getToday(): BigDecimal|\Brick\Math\BigNumber
    {
        return $this->today;
    }

    public function getLast24Hours(): BigDecimal|\Brick\Math\BigNumber
    {
        return $this->last24Hours;
    }
}