<?php

namespace Konair\HAP\Shared\Infrastructure\Domain\Model\EventStore;

use Exception;
use JMS\Serializer\SerializerBuilder;
use Konair\HAP\Shared\Infrastructure\SerializationHandler\CarbonIntervalSerializationHandler;
use Konair\HAP\Shared\Infrastructure\SerializationHandler\CarbonSerializationHandler;
use PDO;
use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;
use Konair\HAP\Shared\Domain\Model\PenColorChanged;
use Konair\HAP\Shared\Domain\Model\PenId;

final class PDOEventStoreTest extends TestCase
{
    private PDOEventStore $eventStore;

    protected function setUp(): void
    {
        $tableName = 'test_domain_events';
        $database = new PDO('sqlite:test_db.sqlite3');
        $stmt = $database->prepare('DROP TABLE IF EXISTS `' . $tableName . '`');
        $stmt->execute();
        $stmt = $database->prepare('CREATE TABLE `' . $tableName . '` (
              `id` varchar(36) NOT NULL,
              `aggregateId` varchar(36) NOT NULL,
              `type` varchar(255) NOT NULL,
              `data` longtext NOT NULL,
              `createdAt` datetime NOT NULL
            )');
        $stmt->execute();

        $serializer = SerializerBuilder::create()
            ->configureHandlers(CarbonSerializationHandler::create())
            ->configureHandlers(CarbonIntervalSerializationHandler::create())
            ->build();
        $this->eventStore = new PDOEventStore($database, $serializer, $tableName);
    }

    protected function tearDown(): void
    {
    }

    /** @throws Exception */
    public function testEmptyEventStore(): void
    {
        $penId = PenId::create();

        $events = $this->eventStore->allStoredEvent($penId);

        $this->assertTrue($events->aggregateId()->equalsTo($penId));
        $this->assertCount(0, $events->events());
    }

    /** @throws Exception */
    public function testTheStoreAppending(): void
    {
        $penId = PenId::create();
        $events = new EventStream(
            $penId,
            new DomainEventCollection(
                new PenColorChanged($penId, 'red'),
            )
        );

        $this->eventStore->append($events);
        $events = $this->eventStore->allStoredEvent($penId);

        $this->assertTrue($events->aggregateId()->equalsTo($penId));
        $this->assertCount(1, $events->events());
        $this->assertInstanceOf(PenColorChanged::class, $events->events()[0]);
    }

    /** @throws Exception */
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
