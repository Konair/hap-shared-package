<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Model\EventStore;

use JMS\Serializer\SerializerInterface;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStore;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;

final class InMemoryEventStore implements EventStore
{
    private SerializerInterface $serializer;
    /** @var array<string, array> */
    private array $serializedEvents;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->serializedEvents = [];
    }

    public function append(EventStream $events): void
    {
        $aggregateId = $events->aggregateId()->value();
        $this->serializedEvents[$aggregateId] = $this->serializedEvents[$aggregateId] ?? [];

        foreach ($events->events() as $event) {
            $this->serializedEvents[$aggregateId][] = $this->serializer->serialize([
                'type' => get_class($event),
                'data' => $this->serializer->serialize($event, 'json'),
            ], 'json');
        }
    }

    public function allStoredEvent(Identification $aggregateId): EventStream
    {
        $domainEvents = new DomainEventCollection();

        foreach ($this->serializedEvents[$aggregateId->value()] ?? [] as $serializedEvent) {
            /**
             * @template T
             * @var class-string<T> $eventDataType
             */
            $eventDataType = 'array';
            $eventData = $this->serializer->deserialize(
                $serializedEvent,
                $eventDataType,
                'json'
            );
            /**
             * @template T
             * @var class-string<T> $domainEventType
             */
            $domainEventType = $eventData['type'];
            $domainEvents = $domainEvents->append(
                $this->serializer->deserialize(
                    $eventData['data'],
                    $domainEventType,
                    'json'
                )
            );
        }

        return new EventStream($aggregateId, $domainEvents);
    }

    public function byType(string $type): DomainEventCollection
    {
        $domainEvents = new DomainEventCollection();

        $serializedEvents = [];
        foreach ($this->serializedEvents as $events) {
            $serializedEvents = array_merge($serializedEvents, $events);
        }

        foreach ($serializedEvents as $serializedEvent) {
            /**
             * @template T
             * @var class-string<T> $eventDataType
             */
            $eventDataType = 'array';
            $eventData = $this->serializer->deserialize(
                $serializedEvent,
                $eventDataType,
                'json'
            );
            /**
             * @template T
             * @var class-string<T> $domainEventType
             */
            $domainEventType = $eventData['type'];

            if ($domainEventType !== $type) {
                continue;
            }

            $domainEvents = $domainEvents->append(
                $this->serializer->deserialize(
                    $eventData['data'],
                    $domainEventType,
                    'json'
                )
            );
        }

        return $domainEvents;
    }
}
