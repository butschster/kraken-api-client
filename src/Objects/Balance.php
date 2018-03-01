<?php

namespace Butschster\Kraken\Objects;

class Balance
{
    /**
     * @var string
     */
    protected $currency;
    /**
     * @var float
     */
    protected $amount;

    /**
     * @param string $currency
     * @param float $amount
     */
    public function __construct(string $currency, float $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function currency(): string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return (float) number_format($this->amount, 4, '.', '');
    }
}