<?php
declare(strict_types=1);

namespace Butschster\Kraken\Requests;

use Brick\Math\BigDecimal;
use Butschster\Kraken\ValueObjects\CloseOrder;
use Butschster\Kraken\ValueObjects\OrderDirection;
use Butschster\Kraken\ValueObjects\OrderType;
use DateTimeInterface;

class AddOrderRequest implements \Butschster\Kraken\Contracts\AddOrderRequest
{
    private ?int $userRef = null;
    private ?BigDecimal $volume = null;
    private ?CloseOrder $close = null;
    private ?string $price = null;
    private ?string $secondaryPrice = null;
    private ?string $leverage = null;
    private ?array $flags = null;
    private ?int $startAt = null;
    private ?int $expiresAt = null;
    private bool $isTradingAgreed = false;
    private bool $onlyValidate = false;

    public function __construct(
        private OrderType $orderType,
        private OrderDirection $direction,
        private string $pair
    )
    {
    }

    /**
     * Set user reference id
     */
    public function setUserRef(int $userRef): self
    {
        $this->userRef = $userRef;
        return $this;
    }

    public function userRef(): ?int
    {
        return $this->userRef;
    }

    public function pair(): string
    {
        return $this->pair;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }

    public function direction(): OrderDirection
    {
        return $this->direction;
    }

    /**
     * Set order quantity in terms of the base asset
     */
    public function setVolume(BigDecimal $volume): self
    {
        $this->volume = $volume;
        return $this;
    }

    public function volume(): ?BigDecimal
    {
        return $this->volume;
    }

    /**
     * Set conditional close order
     * @param CloseOrder $order
     * @return $this
     */
    public function setCloseOrder(CloseOrder $order): self
    {
        $this->close = $order;
        return $this;
    }

    public function close(): ?CloseOrder
    {
        return $this->close;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function price(): ?string
    {
        return $this->price;
    }

    /**
     * Set Secondary Price
     */
    public function setSecondaryPrice(string $price): self
    {
        $this->secondaryPrice = $price;
        return $this;
    }

    public function secondaryPrice(): ?string
    {
        return $this->secondaryPrice;
    }

    /**
     * Set amount of leverage desired
     */
    public function setLeverage(string $leverage): self
    {
        $this->leverage = $leverage;
        return $this;
    }

    public function leverage(): ?string
    {
        return $this->leverage;
    }

    /**
     * Set order flags
     * @param string[] $flags
     */
    public function setFlags(array $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    public function flags(): ?array
    {
        return $this->flags;
    }

    /**
     * Schedule start time.
     * @param DateTimeInterface $time
     * @return $this
     */
    public function scheduleStartTime(DateTimeInterface $time): self
    {
        $this->startAt = $time->getTimestamp();
        return $this;
    }

    public function startAt(): ?int
    {
        return $this->startAt;
    }

    public function setExpirationTime(DateTimeInterface $time): self
    {
        $this->expiresAt = $time->getTimestamp();
        return $this;
    }

    public function expiresAt(): ?int
    {
        return $this->expiresAt;
    }

    public function agreeTrading(): self
    {
        $this->isTradingAgreed = true;
        return $this;
    }

    public function isTradingAgreed(): bool
    {
        return $this->isTradingAgreed;
    }

    public function onlyValidate(): self
    {
        $this->onlyValidate = true;
        return $this;
    }

    public function isOnlyValidate(): bool
    {
        return $this->onlyValidate;
    }

    public function toArray()
    {
        $params = [
            'ordertype' => $this->orderType()->value(),
            'type' => $this->direction()->value(),
            'pair' => $this->pair(),
        ];

        if ($this->userRef()) {
            $params['userref'] = $this->userRef();
        }

        if ($this->volume()) {
            $params['volume'] = (string)$this->volume();
        }

        if ($this->price()) {
            $params['price'] = $this->price();
        }

        if ($this->secondaryPrice()) {
            $params['price2'] = $this->secondaryPrice();
        }

        if ($this->leverage()) {
            $params['leverage'] = $this->leverage();
        }

        if ($this->flags()) {
            $params['oflags'] = implode(',', $this->flags());
        }

        if ($this->startAt() !== null) {
            $params['starttm'] = $this->startAt();
        }

        if ($this->expiresAt() !== null) {
            $params['expiretm'] = $this->expiresAt();
        }

        if ($this->close()) {
            $params['close'] = [
                'ordertype' => $this->close()->orderType()->value(),
                'price' => $this->close()->price(),
                'price2' => $this->close()->secondaryPrice(),
            ];
        }

        if ($this->isTradingAgreed()) {
            $params['trading_agreement'] = 'agreed';
        }

        if ($this->isOnlyValidate()) {
            $params['validate'] = true;
        }

        return $params;
    }
}