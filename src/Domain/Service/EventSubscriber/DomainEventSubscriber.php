<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Service\EventSubscriber;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;
use Konair\HAP\Shared\Domain\Service\EventSubscriber\Exception\NotSubscribedException;

interface DomainEventSubscriber
{
    /**
     * @param Identification $identification AggregateRoot Identification
     * @param DomainEvent $event
     * @throws NotSubscribedException
     */
    public function handle(Identification $identification, DomainEvent $event): void;

    public function isSubscribedTo(DomainEvent $event): bool;
}
