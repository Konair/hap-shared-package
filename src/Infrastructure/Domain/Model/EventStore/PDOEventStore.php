<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Model\EventStore;

use Carbon\CarbonImmutable;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use PDO;
use PDOStatement;
use Ramsey\Uuid\Uuid;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEventCollection;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStore;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;

final class PDOEventStore implements EventStore
{
    public function __construct(
        private PDO $database,
        private SerializerInterface $serializer,
        private string $tableName,
    ) {
    }

    /**
     * @param EventStream $events
     * @throws Exception
     */
    public function append(EventStream $events): void
    {
        try {
            $this->database->beginTransaction();
            $stmt = $this->database->prepare(
                'INSERT INTO ' . $this->tableName . ' (id, type, aggregateId, data, createdAt) '
                . 'VALUES (:id, :type, :aggregateId, :data, :createdAt)'
            );

            if (!$stmt instanceof PDOStatement) {
                throw new Exception();
            }

            ;

            foreach ($events->events() as $event) {
                $stmt->execute([
                    'id' => Uuid::uuid4()->toString(),
                    'aggregateId' => $events->aggregateId()->value(),
                    'type' => get_class($event),
                    'data' => $this->serializer->serialize(
                        $event,
                        'json',
                        SerializationContext::create()->setSerializeNull(true),
                    ),
                    'createdAt' => CarbonImmutable::now()->format('Y-m-d H:i:s.u'),
                ]);
            }

            $this->database->commit();
        } catch (Exception $exception) {
            $this->database->rollback();
            throw $exception;
        }
    }

    /**
     * @param Identification $aggregateId
     * @return EventStream
     * @throws Exception
     */
    public function allStoredEvent(Identification $aggregateId): EventStream
    {
        $domainEvents = new DomainEventCollection();

        $stmt = $this->database->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE aggregateId = :aggregateId ORDER BY createdAt ASC'
        );

        if (!$stmt instanceof PDOStatement) {
            throw new Exception();
        }

        $stmt->execute(['aggregateId' => $aggregateId]);
        $storedEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($storedEvents === false) {
            throw new Exception();
        }

        foreach ($storedEvents as $storedEvent) {
            /**
             * @template T
             * @var class-string<T> $storedEventType
             */
            $storedEventType = $storedEvent['type'];
            $domainEvents = $domainEvents->append(
                $this->serializer->deserialize(
                    $storedEvent['data'],
                    $storedEventType,
                    'json'
                )
            );
        }

        return new EventStream($aggregateId, $domainEvents);
    }

    /**
     * @param string $type
     * @return DomainEventCollection
     * @throws Exception
     */
    public function byType(string $type): DomainEventCollection
    {
        $domainEvents = new DomainEventCollection();

        $stmt = $this->database->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE type = :type ORDER BY createdAt ASC'
        );

        if (!$stmt instanceof PDOStatement) {
            throw new Exception();
        }

        $stmt->execute(['type' => $type]);

        $storedEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($storedEvents === false) {
            throw new Exception();
        }

        foreach ($storedEvents as $storedEvent) {
            /**
             * @template T
             * @var class-string<T> $storedEventType
             */
            $storedEventType = $storedEvent['type'];
            $domainEvents = $domainEvents->append(
                $this->serializer->deserialize(
                    $storedEvent['data'],
                    $storedEventType,
                    'json'
                )
            );
        }

        return $domainEvents;
    }
}
