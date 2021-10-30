<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EventStore;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;

final class EventStream
{
    public function __construct(
        private Identification $aggregateId,
        private DomainEventCollection $events,
    ) {
    }

    public function aggregateId(): Identification
    {
        return $this->aggregateId;
    }

    public function events(): DomainEventCollection
    {
        return $this->events;
    }
}
