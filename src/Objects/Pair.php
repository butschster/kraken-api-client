<?php

namespace Butschster\Kraken\Objects;

class Pair
{
    /**
     * @var string
     */
    protected $pair;

    /**
     * @var array
     */
    protected $information;

    /**
     * @param string $pair
     * @param array $information
     */
    public function __construct(string $pair, array $information)
    {
        $this->pair = $pair;
        $this->information = $information;
    }

    /**
     * Pair name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->pair;
    }

    /**
     * Alternate pair name
     *
     * @return string
     */
    public function altname(): string
    {
        return $this->information['altname'];
    }

    /**
     * Asset id of base component
     *
     * @return string
     */
    public function base(): string
    {
        return $this->information['base'];
    }

    /**
     * Asset id of quote component
     * @return string
     */
    public function quote(): string
    {
        return $this->information['quote'];
    }

    /**
     * Volume lot size
     *
     * @return string
     */
    public function lot(): string
    {
        return $this->information['lot'];
    }
}