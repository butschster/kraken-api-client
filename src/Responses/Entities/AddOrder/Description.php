<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities\AddOrder;

use JMS\Serializer\Annotation\Type;

class Description
{
    /**
     * Order description
     * @Type("string")
     */
    public string $order;

    /**
     * Conditional close order description, if applicable
     * @Type("string")
     */
    public string $close = '';
}