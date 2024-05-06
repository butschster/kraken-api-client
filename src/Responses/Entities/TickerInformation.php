<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Brick\Math\BigDecimal;
use Butschster\Kraken\Responses\Entities\TickerInformation\LotPrice;
use Butschster\Kraken\Responses\Entities\TickerInformation\Price;
use Butschster\Kraken\Responses\Entities\TickerInformation\Trades;
use Butschster\Kraken\Responses\Entities\TickerInformation\Volume;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class TickerInformation
{
    #[Type("array<string>")]
    #[SerializedName("a")]
    #[Accessor(setter: "setAsk")]
    public LotPrice $ask;

    #[Type("array<string>")]
    #[SerializedName("b")]
    #[Accessor(setter: "setBid")]
    public LotPrice $bid;

    #[Type(BigDecimal::class)]
    #[SerializedName("o")]
    public BigDecimal $openingPrice;

    /**
     * Last trade closed [<price>, <lot volume>]
     */
    #[SerializedName("c")]
    #[Type("array<string>")]
    public array $lastTradeClosed = [];

    /**
     * Volume [<today>, <last 24 hours>]
     */
    #[SerializedName("v")]
    #[Type("array<string>")]
    #[Accessor(setter: "setVolume")]
    public Volume $volume;

    /**
     * Volume weighted average price [<today>, <last 24 hours>]
     */
    #[SerializedName("p")]
    #[Type("array<string>")]
    #[Accessor(setter: "setVolumeWightedAveragePrice")]
    public Volume $volumeWightedAveragePrice;

    /**
     * Number of trades [<today>, <last 24 hours>]
     */
    #[SerializedName("t")]
    #[Type("array<int>")]
    #[Accessor(setter: "setTrades")]
    public Trades $trades;

    /**
     * Low [<today>, <last 24 hours>]
     */
    #[SerializedName("l")]
    #[Type("array<string>")]
    #[Accessor(setter: "setLow")]
    public Price $low;

    /**
     * High [<today>, <last 24 hours>]
     */
    #[SerializedName("h")]
    #[Type("array<string>")]
    #[Accessor(setter: "setHigh")]
    public Price $high;

    public function setAsk(array $ask): void
    {
        $this->ask = new LotPrice(...$ask);
    }

    public function setBid(array $bid): void
    {
        $this->bid = new LotPrice(...$bid);
    }

    public function setVolume(array $volume): void
    {
        $this->volume = new Volume(...$volume);
    }

    public function setVolumeWightedAveragePrice(array $volume): void
    {
        $this->volumeWightedAveragePrice = new Volume(...$volume);
    }

    public function setTrades(array $trades): void
    {
        $this->trades = new Trades(...$trades);
    }

    public function setLow(array $low): void
    {
        $this->low = new Price(...$low);
    }

    public function setHigh(array $high): void
    {
        $this->high = new Price(...$high);
    }
}
