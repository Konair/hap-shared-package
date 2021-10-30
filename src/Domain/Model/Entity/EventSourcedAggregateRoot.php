<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Entity;

use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;

interface EventSourcedAggregateRoot
{
    public static function reconstitute(EventStream $history): EventSourcedAggregateRoot;
}
