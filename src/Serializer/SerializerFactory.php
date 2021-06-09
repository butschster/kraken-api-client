<?php
declare(strict_types=1);

namespace Butschster\Kraken\Serializer;

use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;

class SerializerFactory
{
    public function build()
    {
        $builder = SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new SerializedNameAnnotationStrategy(
                    new IdenticalPropertyNamingStrategy()
                )
            )
            ->addDefaultHandlers()
            ->configureHandlers(function(HandlerRegistry $registry) {
                $registry->registerSubscribingHandler(new BigDecimalHandler());
                $registry->registerSubscribingHandler(new TimestampHandler());
                $registry->registerSubscribingHandler(new ComaSeparatedHandler());
            });

        return $builder->build();
    }
}
