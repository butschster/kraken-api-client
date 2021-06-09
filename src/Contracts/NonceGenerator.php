<?php
declare(strict_types=1);

namespace Butschster\Kraken\Contracts;

interface NonceGenerator
{
    /**
     * Generate a 64 bit nonce using a timestamp at microsecond resolution
     * string functions are used to avoid problems on 32 bit systems
     *
     * @return string
     */
    public function generate(): string;
}