<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\AMQPBroker;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Konair\HAP\Shared\Infrastructure\Projection\Producer;

final class RabbitMQProducer implements Producer
{
    private AMQPStreamConnection $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function publish(string $queueName, string $message): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($queueName, false, false, false, false);

        $channel->basic_publish(new AMQPMessage($message), '', $queueName);

        $channel->close();
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}
