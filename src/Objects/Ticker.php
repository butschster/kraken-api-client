<?php

namespace Butschster\Kraken\Objects;

use Illuminate\Support\Arr;

class Ticker
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $pair;

    /**
     * @param string $pair
     * @param array $data
     */
    public function __construct(string $pair, array $data)
    {
        $this->data = $data;
        $this->pair = $pair;
    }

    /**
     * @return string
     */
    public function pair(): string
    {
        return $this->pair;
    }

    /**
     * Ask price
     * @return mixed
     */
    public function askPrice(): float
    {
        return (float) Arr::get($this->data, 'a.0', 0);
    }

    /**
     * Ask whole lot volume
     * @return mixed
     */
    public function askWholeLotVolume(): float
    {
        return (float) Arr::get($this->data, 'a.1', 0);
    }

    /**
     * Ask lot volume
     * @return mixed
     */
    public function askLotVolume(): float
    {
        return (float) Arr::get($this->data, 'a.2', 0);
    }

    /**
     * Bid price
     * @return mixed
     */
    public function bidPrice(): float
    {
        return (float) Arr::get($this->data, 'b.0', 0);
    }

    /**
     * Bid whole lot volume
     * @return mixed
     */
    public function bidWholeLotVolume(): float
    {
        return (float) Arr::get($this->data, 'b.1', 0);
    }

    /**
     * Bid lot volume
     * @return mixed
     */
    public function bidLotVolume(): float
    {
        return (float) Arr::get($this->data, 'b.2', 0);
    }

    /**
     * Last trade closed price
     *
     * @return float
     */
    public function lastClosedPrice(): float
    {
        return (float) Arr::get($this->data, 'c.0', 0);
    }

    /**
     * Last trade closed price
     *
     * @return float
     */
    public function lastLotVolume(): float
    {
        return (float) Arr::get($this->data, 'c.1', 0);
    }

    /**
     * Today volume
     *
     * @return float
     */
    public function volumeToday(): float
    {
        return (float) Arr::get($this->data, 'v.0', 0);
    }

    /**
     * Last 24 hours volume
     *
     * @return float
     */
    public function volumePrevious(): float
    {
        return (float) Arr::get($this->data, 'v.1', 0);
    }

    /**
     * Today volume weighted average price
     *
     * @return float
     */
    public function avgPriceVolumeToday(): float
    {
        return (float) Arr::get($this->data, 'p.0', 0);
    }

    /**
     * Last 24 volume weighted average price
     *
     * @return float
     */
    public function avgPriceVolumPrevious(): float
    {
        return (float) Arr::get($this->data, 'v.1', 0);
    }
}
