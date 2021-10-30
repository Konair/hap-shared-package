<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Service\EventSubscriber\Spy;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;
use Konair\HAP\Shared\Domain\Service\EventSubscriber\DomainEventSubscriber;

final class SpySubscriber implements DomainEventSubscriber
{
    /** @var array<string, array<DomainEvent>> */
    private array $events = [];

    /** @return array<string, array<DomainEvent>> */
    public function events(): array
    {
        return $this->events;
    }

    public function handle(Identification $identification, DomainEvent $event): void
    {
        $aggregateRootId = $identification->value();
        $this->events[$aggregateRootId] = $this->events[$aggregateRootId] ?? [];
        $this->events[$aggregateRootId][] = $event;
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }
}
