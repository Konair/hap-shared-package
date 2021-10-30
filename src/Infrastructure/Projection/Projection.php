<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Projection;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;

interface Projection
{
    public function listensTo(): string;

    public function project(DomainEvent $event): void;
}
