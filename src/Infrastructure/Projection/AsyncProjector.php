<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Projection;

use JMS\Serializer\SerializerInterface;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;

final class AsyncProjector
{
    public function __construct(
        private Producer $producer,
        private SerializerInterface $serializer
    ) {
    }

    /** @param DomainEvent[] $events */
    public function project(string $queueName, array $events): void
    {
        foreach ($events as $event) {
            $this->producer->publish(
                $queueName,
                $this->serializer->serialize(
                    $event,
                    'json'
                )
            );
        }
    }
}
