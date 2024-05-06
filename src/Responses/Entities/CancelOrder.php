<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use JMS\Serializer\Annotation\Type;

class CancelOrder
{
    /**
     * Number of orders cancelled.
     */
    #[Type("int")]
    public int $count = 0;

    /**
     * if set, order(s) is/are pending cancellation
     */
    #[Type("bool")]
    public ?bool $pending = null;
}
