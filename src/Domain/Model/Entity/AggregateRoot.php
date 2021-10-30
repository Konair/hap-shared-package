<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Entity;

use ReflectionClass;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;
use Konair\HAP\Shared\Domain\Service\EventSubscriber\DomainEventPublisher;

/**
 * @template T of \Konair\HAP\Shared\Domain\Model\Identification\Identification
 * @implements Entity<T>
 */
abstract class AggregateRoot implements Entity
{
    /**
     * @var DomainEvent[] $recordedEvents
     * @JMS\Serializer\Annotation\Exclude();
     */
    protected array $recordedEvents = [];

    protected function recordApplyAndPublishThat(DomainEvent $domainEvent): void
    {
        $this->recordThat($domainEvent);
        $this->applyThat($domainEvent);
        $this->publishThat($domainEvent);
    }

    protected function recordThat(DomainEvent $domainEvent): void
    {
        $this->recordedEvents[] = $domainEvent;
    }

    protected function applyThat(DomainEvent $domainEvent): void
    {
        $modifier = 'apply' . (new ReflectionClass($domainEvent))->getShortName();

        if (method_exists($this, $modifier)) {
            $this->$modifier($domainEvent);
        }
    }

    protected function publishThat(DomainEvent $domainEvent): void
    {
        DomainEventPublisher::instance()->publish($this->identification(), $domainEvent);
    }

    /** @return DomainEvent[] */
    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearEvents(): void
    {
        $this->recordedEvents = [];
    }
}
