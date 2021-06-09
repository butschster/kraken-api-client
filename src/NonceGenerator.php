<?php
declare(strict_types=1);

namespace Butschster\Kraken;

class NonceGenerator implements Contracts\NonceGenerator
{
    /** @inheritDoc */
    public function generate(): string
    {
        $nonce = explode(' ', microtime());
        return $nonce[1] . str_pad(substr($nonce[0], 2, 6), 6, '0');
    }
}