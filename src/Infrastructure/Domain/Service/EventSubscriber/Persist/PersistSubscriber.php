<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Service\EventSubscriber\Persist;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStore;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;
use Konair\HAP\Shared\Domain\Service\EventSubscriber\DomainEventSubscriber;
use Konair\HAP\Shared\Domain\Service\EventSubscriber\Exception\NotSubscribedException;

final class PersistSubscriber implements DomainEventSubscriber
{
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @inheritDoc
     */
    public function handle(Identification $identification, DomainEvent $event): void
    {
        if (!$this->isSubscribedTo($event)) {
            throw new NotSubscribedException();
        }

        $this->eventStore->append(
            new EventStream(
                $identification,
                new DomainEventCollection($event),
            )
        );
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }
}
