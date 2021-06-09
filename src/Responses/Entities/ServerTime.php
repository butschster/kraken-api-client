<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use DateTimeInterface;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

class ServerTime
{
    /**
     * Unix timestamp
     * @SerializedName("unixtime")
     * @Type("Timestamp")
     */
    public DateTimeInterface $time;

    /**
     * RFC 1123 time format
     */
    public string $rfc1123;
}
