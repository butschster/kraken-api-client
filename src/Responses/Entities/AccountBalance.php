<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Brick\Math\BigDecimal;

class AccountBalance
{
    private BigDecimal $balance;

    public function __construct(private string $asset, string $balance)
    {
        $this->balance = BigDecimal::of($balance);
    }

    public function getBalance(): BigDecimal
    {
        return $this->balance;
    }

    public function getAsset(): string
    {
        return $this->asset;
    }
}