<?php

namespace Butschster\Kraken;

use Butschster\Kraken\Exceptions\MinimalVolumeSizeNotFound;
use Butschster\Kraken\Objects\Pair;

class OrderVolume
{
    /**
     * Check minimal volume size for selected pair
     *
     * @param Pair $pair
     * @param float $volume
     * @return bool
     * @throws MinimalVolumeSizeNotFound
     */
    public function checkMinimalSizeForPair(Pair $pair, float $volume): bool
    {
        return $this->getMinimalSizeForPair($pair) < $volume;
    }

    /**
     * Check minimal volume size for selected currency
     *
     * @param string $currency
     * @param float $volume
     * @return bool
     * @throws MinimalVolumeSizeNotFound
     */
    public function checkMinimalSize(string $currency, float $volume): bool
    {
        return $this->getMinimalSize($currency) < $volume;
    }

    /**
     * Get minimal volume size for selected pair
     *
     * @param Pair $pair
     * @return mixed
     * @throws MinimalVolumeSizeNotFound
     */
    public function getMinimalSizeForPair(Pair $pair)
    {
        return $this->getMinimalSize($pair->base());
    }

    /**
     * Get minimal volume size for selected currency
     *
     * @param string $currency
     * @return mixed
     * @throws MinimalVolumeSizeNotFound
     */
    public function getMinimalSize(string $currency)
    {
        $minimalSize = config('kraken.minimal_volumes.'.$currency);

        if (is_null($minimalSize)) {
            throw new MinimalVolumeSizeNotFound("Minimal volume size for currency [{$currency}] not found.");
        }

        return $minimalSize;
    }
}