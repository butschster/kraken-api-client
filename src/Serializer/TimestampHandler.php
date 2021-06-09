<?php
declare(strict_types=1);

namespace Butschster\Kraken\Serializer;

use Carbon\Carbon;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;

class TimestampHandler implements SubscribingHandlerInterface
{

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'Timestamp',
                'method' => 'deserialize',
            ],
        ];
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $string, array $type, Context $context)
    {
        return Carbon::createFromTimestamp($string);
    }
}
