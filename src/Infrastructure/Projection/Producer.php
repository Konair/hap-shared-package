<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Projection;

interface Producer
{
    public function publish(string $queueName, string $message): void;
}
