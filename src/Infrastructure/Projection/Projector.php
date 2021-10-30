<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Projection;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;

interface Projector
{
    /** @param Projection[] $projections */
    public function register(array $projections): void;

    /** @param DomainEvent[] $events */
    public function project(array $events): void;
}
