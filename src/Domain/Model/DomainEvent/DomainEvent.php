<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\DomainEvent;

use Carbon\CarbonImmutable;

interface DomainEvent
{
    public function occurredOn(): CarbonImmutable;
}
