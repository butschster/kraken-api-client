<?php
declare(strict_types=1);

namespace Butschster\Kraken\Serializer;

use Brick\Math\BigDecimal;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;

class ComaSeparatedHandler implements SubscribingHandlerInterface
{

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'ComaSeparated',
                'method' => 'deserialize',
            ],
        ];
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $string, array $type, Context $context)
    {
        return array_filter(explode(',', $string));
    }
}
