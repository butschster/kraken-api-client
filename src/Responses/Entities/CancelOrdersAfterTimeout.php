<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use DateTimeInterface;
use JMS\Serializer\Annotation\Type;

class CancelOrdersAfterTimeout
{
    /**
     * Timestamp (RFC3339 format) at which the request was received
     * @Type("DateTimeInterface")
     */
    public DateTimeInterface $currentTime;

    /**
     * Timestamp (RFC3339 format) after which all orders will be cancelled, unless the timer is extended or disabled
     * @Type("DateTimeInterface")
     */
    public DateTimeInterface $triggerTime;
}