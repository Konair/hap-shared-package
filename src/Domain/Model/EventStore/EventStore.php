<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EventStore;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;

interface EventStore
{
    public function append(EventStream $events): void;

    /**
     * @param Identification $aggregateId
     * @return EventStream
     */
    public function allStoredEvent(Identification $aggregateId): EventStream;

    /**
     * @param string $type
     * @return DomainEventCollection
     */
    public function byType(string $type): DomainEventCollection;
}
