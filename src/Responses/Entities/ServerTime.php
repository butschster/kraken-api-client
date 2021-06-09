<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Carbon\Carbon;

class ServerTime
{
    /**
     * Unix timestamp
     */
    public int $unixtime = 0;

    /**
     * RFC 1123 time format
     */
    public string $rfc1123;

    public function time(): \DateTimeInterface
    {
        return Carbon::createFromTimestamp($this->unixtime);
    }
}