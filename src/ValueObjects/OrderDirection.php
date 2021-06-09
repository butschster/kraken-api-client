<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

/**
 * @method static OrderDirection sell()
 * @method static OrderDirection buy()
 */
class OrderDirection extends Enum
{
    const sell = 'sell';
    const buy = 'buy';
}