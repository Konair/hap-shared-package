<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\SerializationHandler;

use Carbon\CarbonInterval;
use Closure;
use Exception;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;

final class CarbonIntervalSerializationHandler implements SubscribingHandlerInterface
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
                'type' => CarbonInterval::class,
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => CarbonInterval::class,
                'method' => 'deserialize',
            ],
        ];
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param CarbonInterval $carbon
     * @return int[]
     */
    public function serialize(JsonSerializationVisitor $visitor, CarbonInterval $carbon): array
    {
        return $carbon->toArray();
    }

    /**
     * @param JsonDeserializationVisitor $visitor
     * @param int[] $data
     * @return CarbonInterval
     * @throws Exception
     */
    public function deserialize(JsonDeserializationVisitor $visitor, array $data): CarbonInterval
    {
        return CarbonInterval::create(
            $data['years'],
            $data['months'],
            $data['weeks'],
            $data['days'],
            $data['hours'],
            $data['minutes'],
            $data['seconds'],
            $data['microseconds'],
        );
    }
}
