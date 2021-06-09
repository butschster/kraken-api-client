<?php
declare(strict_types=1);

namespace Butschster\Kraken\Serializer;

use Brick\Math\BigDecimal;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\Context;

class BigDecimalHandler implements SubscribingHandlerInterface
{

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'BigDecimal',
                'method' => 'deserialize',
            ],
        ];
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $string, array $type, Context $context)
    {
        return BigDecimal::of($string);
    }
}
