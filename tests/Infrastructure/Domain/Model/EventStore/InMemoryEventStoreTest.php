<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Model\EventStore;

use JMS\Serializer\SerializerBuilder;
use Konair\HAP\Shared\Infrastructure\SerializationHandler\CarbonIntervalSerializationHandler;
use Konair\HAP\Shared\Infrastructure\SerializationHandler\CarbonSerializationHandler;
use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStore;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;
use Konair\HAP\Shared\Domain\Model\PenColorChanged;
use Konair\HAP\Shared\Domain\Model\PenId;

final class InMemoryEventStoreTest extends TestCase
{
    private EventStore $eventStore;

    protected function setUp(): void
    {
        $serializer = SerializerBuilder::create()
            ->configureHandlers(CarbonSerializationHandler::create())
            ->configureHandlers(CarbonIntervalSerializationHandler::create())
            ->build();
        $this->eventStore = new InMemoryEventStore($serializer);
    }

    public function testEmptyEventStore(): void
    {
        $penId = PenId::create();

        $events = $this->eventStore->allStoredEvent($penId);

        $this->assertTrue($events->aggregateId()->equalsTo($penId));
        $this->assertCount(0, $events->events());
    }

    public function testTheStoreAppending(): void
    {
        $penId = PenId::create();
        $events = new EventStream(
            $penId,
            new DomainEventCollection(
                new PenColorChanged($penId, 'red')
            )
        );

        $this->eventStore->append($events);
        $events = $this->eventStore->allStoredEvent($penId);

        $this->assertTrue($events->aggregateId()->equalsTo($penId));
        $this->assertCount(1, $events->events());
        $this->assertInstanceOf(PenColorChanged::class, $events->events()[0]);
    }

    public function testToGetEventsByType(): void
    {
        $penId = PenId::create();
        $events = new EventStream(
            $penId,
            new DomainEventCollection(
                new PenColorChanged($penId, 'red'),
                new PenColorChanged($penId, 'blue'),
                new PenColorChanged($penId, 'green'),
            )
        );

        $this->eventStore->append($events);
        $domainEvents = $this->eventStore->byType(PenColorChanged::class);

        $this->assertInstanceOf(DomainEventCollection::class, $domainEvents);
        $this->assertCount(3, $domainEvents);
        $this->assertInstanceOf(PenColorChanged::class, $domainEvents[0]);
    }
}
