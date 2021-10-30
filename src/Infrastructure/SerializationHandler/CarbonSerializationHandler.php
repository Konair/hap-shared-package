<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\SerializationHandler;

use Carbon\CarbonImmutable;
use Closure;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\Context;

final class CarbonSerializationHandler implements SubscribingHandlerInterface
{
    public static function create(): Closure
    {
        return function (HandlerRegistry $registry) {
            $registry->registerSubscribingHandler(new self());
        };
    }

    /** @return array[] */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => CarbonImmutable::class,
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => CarbonImmutable::class,
                'method' => 'deserialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, CarbonImmutable $carbon): string
    {
        return $carbon->toW3cString();
    }

    public function deserialize(JsonDeserializationVisitor $visitor, string $dateTimeString): CarbonImmutable
    {
        return CarbonImmutable::parse($dateTimeString);
    }
}
