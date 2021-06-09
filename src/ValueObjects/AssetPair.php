<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

class AssetPair
{
    public function __construct(
        private string $asset1,
        private string $asset2
    )
    {
    }

    /**
     * @return string
     */
    public function getAsset1(): string
    {
        return $this->asset1;
    }

    /**
     * @return string
     */
    public function getAsset2(): string
    {
        return $this->asset2;
    }

    final public function equals(self $pair): bool
    {
        return (string)$this === (string)$pair;
    }

    public function __toString(): string
    {
        return sprintf('%s,%s', $this->asset1, $this->asset2);
    }
}