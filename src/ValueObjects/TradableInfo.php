<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

/**
 * @method static TradableInfo info()
 * @method static TradableInfo leverage()
 * @method static TradableInfo fees()
 * @method static TradableInfo margin()
 */
class TradableInfo extends Enum
{
    const info = 'info';
    const leverage = 'leverage';
    const fees = 'fees';
    const margin = 'margin';
}