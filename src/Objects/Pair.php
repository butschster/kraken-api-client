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
     * @return string
     */
    public function name(): string
    {
        return $this->pair;
    }

    /**
     * @return string
     */
    public function altname(): string
    {
        return $this->information['altname'];
    }
}