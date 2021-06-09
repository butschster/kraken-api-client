<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses\Entities;

use Carbon\Carbon;
use DateTimeInterface;
use JMS\Serializer\Annotation\Type;

class WebsocketToken
{
    /**
     * Websockets token
     * @Type("string")
     */
    public string $token;

    /**
     * Time (in seconds) after which the token expires
     * @Type("int")
     */
    public int $expires;

    /**
     * Date after which the token expires
     */
    public function expiresAt(): DateTimeInterface
    {
        return Carbon::now()->addSeconds($this->expires);
    }
}