<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

class AssetPair
{
    /**
     * @param string $asset1
     * @param string|null $asset2
     * @param string[] $assets
     */
    public function __construct(
        private string $asset1,
        private ?string $asset2 = null,
        private array $assets = [],
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
     * @return ?string
     */
    public function getAsset2(): ?string
    {
        return $this->asset2;
    }

    /**
     * @return string[]
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    final public function equals(self $pair): bool
    {
        return (string)$this === (string)$pair;
    }

    public function __toString(): string
    {
        $assets = [$this->asset1];
        if($this->asset2 !== null)
            $assets[] = $this->asset2;

        return implode(',', array_merge($assets,$this->assets));
    }
}
