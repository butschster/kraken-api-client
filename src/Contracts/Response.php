<?php
declare(strict_types=1);

namespace Butschster\Kraken\Contracts;

interface Response
{
    /**
     * Check if response has errors
     */
    public function hasErrors(): bool;
}
