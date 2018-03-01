<?php

namespace Butschster\Kraken\Objects;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class Order implements Arrayable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $information;

    /**
     * @param string $id
     * @param array $information
     */
    public function __construct(string $id, array $information)
    {
        $this->id = $id;
        $this->information = $information;
    }

    /**
     * @return Carbon
     */
    public function openDate(): Carbon
    {
        return Carbon::createFromTimestamp($this->information['opentm']);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function status()
    {
        return $this->information['status'] ?: null;
    }

    /**
     * @return float
     */
    public function volume(): float
    {
        return $this->information['vol'] ?: 0.0;
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->information['price'] ?: 0.0;
    }

    /**
     * @return float
     */
    public function cost(): float
    {
        return $this->information['cost'] ?: 0.0;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(['txid' => $this->id], $this->information);
    }
}