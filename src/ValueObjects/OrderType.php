<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

/**
 * @method static OrderType market()
 * @method static OrderType limit()
 * @method static OrderType stopLoss()
 * @method static OrderType takeProfit()
 * @method static OrderType stopLossLimit()
 * @method static OrderType takeProfitLimit()
 * @method static OrderType settlePosition()
 */
class OrderType extends Enum
{
    const market = 'market';
    const limit = 'limit';
    const stopLoss = 'stop-loss';
    const takeProfit = 'take-profit';
    const stopLossLimit = 'stop-loss-limit';
    const takeProfitLimit = 'take-profit-limit';
    const settlePosition = 'settle-position';
}