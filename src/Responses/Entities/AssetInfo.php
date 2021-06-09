<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;
use JMS\Serializer\Annotation\SerializedName;

class AssetInfo
{
    /**
     * Asset class
     * @SerializedName("aclass")
     */
    public string $class;

    /**
     * Alternate name
     */
    public string $altname;

    /**
     * Scaling decimal places for record keeping
     */
    public int $decimals;

    /**
     * Scaling decimal places for output display
     * @SerializedName("display_decimals")
     */
    public int $displayDecimals;
}