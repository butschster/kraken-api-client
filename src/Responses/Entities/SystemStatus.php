<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use DateTimeImmutable;
use JMS\Serializer\Annotation\Type;

class SystemStatus
{
    const ONLINE = 'online';
    const MAINTENANCE = 'maintenance';
    const CANCEL_ONLY = 'cancel_only';
    const POST_ONLY = 'post_only';

    /**
     * Current system status
     *      - online: Kraken is operating normally. All order types may be submitted and trades can occur.
     *      - maintenance: The exchange is offline. No new orders or cancellations may be submitted.
     *      - cancel_only: Resting (open) orders can be cancelled but no new orders may be submitted. No trades will occur.
     *      - post_only: Only post-only limit orders can be submitted. Existing orders may still be cancelled. No trades will occur.
     */
    public string $status;

    /**
     * Current timestamp (RFC3339)
     * @Type("DateTimeImmutable")
     */
    public DateTimeImmutable $timestamp;

    /**
     * Kraken is operating normally. All order types may be submitted and trades can occur.
     */
    public function isOnline(): bool
    {
        return $this->status === self::ONLINE;
    }

    /**
     * The exchange is offline. No new orders or cancellations may be submitted.
     */
    public function isMaintenance(): bool
    {
        return $this->status === self::MAINTENANCE;
    }

    /**
     * Resting (open) orders can be cancelled but no new orders may be submitted. No trades will occur.
     */
    public function isCancelOnly(): bool
    {
        return $this->status === self::CANCEL_ONLY;
    }

    /**
     * Only post-only limit orders can be submitted. Existing orders may still be cancelled. No trades will occur.
     */
    public function isPostOnly(): bool
    {
        return $this->status === self::POST_ONLY;
    }
}
