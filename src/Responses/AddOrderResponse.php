<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Responses\Entities\AddOrder\OrderAdded;

class AddOrderResponse extends AbstractResponse
{
    public ?OrderAdded $result = null;
}