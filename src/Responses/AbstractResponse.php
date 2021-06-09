<?php
declare(strict_types=1);

namespace Butschster\Kraken\Responses;

use Butschster\Kraken\Contracts\Response;
use JMS\Serializer\Annotation\Type;

abstract class AbstractResponse implements Response
{
    /** @Type("array<string>") */
    public ?array $error = null;

    public function hasErrors(): bool
    {
        return !empty($this->error);
    }
}