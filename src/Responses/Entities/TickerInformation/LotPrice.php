<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\TickerInformation;

use Brick\Math\BigDecimal;

class LotPrice
{
    private BigDecimal $price;
    private BigDecimal $wholeLotVolume;
    private BigDecimal $lotVolume;

    public function __construct(
        string $price,
        string $wholeLotVolume,
        string $lotVolume
    )
    {
        $this->price = BigDecimal::of($price);
        $this->wholeLotVolume = BigDecimal::of($wholeLotVolume);
        $this->lotVolume = BigDecimal::of($lotVolume);
    }

    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    public function getWholeLotVolume(): BigDecimal
    {
        return $this->wholeLotVolume;
    }

    public function getLotVolume(): BigDecimal
    {
        return $this->lotVolume;
    }
}