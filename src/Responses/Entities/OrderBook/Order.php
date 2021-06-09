<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\OrderBook;

use Brick\Math\BigDecimal;
use Carbon\Carbon;
use DateTimeInterface;

class Order
{
    private BigDecimal $price;
    private BigDecimal $volume;
    private int $timestamp;
    private DateTimeInterface $date;

    public function __construct(string $price, string $volume, int $timestamp)
    {
        $this->price = BigDecimal::of($price);
        $this->volume = BigDecimal::of($volume);
        $this->timestamp = $timestamp;
        $this->date = Carbon::createFromTimestamp($timestamp);
    }

    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    public function getVolume(): BigDecimal
    {
        return $this->volume;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getDate(): DateTimeInterface|Carbon
    {
        return $this->date;
    }
}