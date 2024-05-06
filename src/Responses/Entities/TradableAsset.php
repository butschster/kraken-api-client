<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class TradableAsset
{
    /**
     * Alternate pair name
     */
    public string $altname;

    /**
     * WebSocket pair name (if available)
     */
    public ?string $wsname = null;

    /**
     * Asset class of base component
     */
    #[SerializedName("aclass_base")]
    public ?string $classBase = null;

    /**
     * Asset ID of base component
     */
    public string $base;

    /**
     * Asset class of quote component
     */
    #[SerializedName("aclass_quote")]
    public string $classQuote;

    /**
     * Asset ID of quote component
     */
    public string $quote;

    /**
     * Scaling decimal places for pair
     */
    #[SerializedName("pair_decimals")]
    public int $pairDecimals = 0;

    /**
     * Scaling decimal places for volume
     */
    #[SerializedName("lot_decimals")]
    public int $lotDecimals = 0;

    /**
     * Amount to multiply lot volume by to get currency volume
     */
    #[SerializedName("lot_multiplier")]
    public int $lotMultiplier = 0;

    /**
     * Array of leverage amounts available when buying
     */
    #[SerializedName("leverage_buy")]
    #[Type("array<int>")]
    public array $leverageBuy = [];

    /**
     * Array of leverage amounts available when selling
     */
    #[SerializedName("leverage_sell")]
    #[Type("array<int>")]
    public array $leverageSell = [];

    /**
     * Fee schedule array in [<volume>, <percent fee>] tuples
     * @var Fee[]
     */
    #[Type("array")]
    #[Accessor(setter: "setFees")]
    public array $fees = [];

    /**
     * Maker fee schedule array in [<volume>, <percent fee>] tuples (if on maker/taker)
     * @var Fee[]
     */
    #[SerializedName("fees_maker")]
    #[Type("array")]
    #[Accessor(setter: "setFeesMaker")]
    public array $feesMaker = [];

    /**
     * Volume discount currency
     */
    #[SerializedName("fee_volume_currency")]
    public string $feeVolumeCurrency;

    /**
     * Margin call level
     */
    #[SerializedName("margin_call")]
    public int $marginCall = 0;

    /**
     * Stop-out/liquidation margin level
     */
    #[SerializedName("margin_stop")]
    public int $marginStop = 0;

    /**
     * Minimum order size (in terms of base currency)
     */
    public string $ordermin;

    public function setFees(array $fees): void
    {
        $this->fees = array_map(fn($fee) => new Fee(...$fee), $fees);
    }

    public function setFeesMaker(array $fees): void
    {
        $this->feesMaker = array_map(fn($fee) => new Fee(...$fee), $fees);
    }
}
