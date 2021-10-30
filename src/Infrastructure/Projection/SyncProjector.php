<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Projection;

use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;

final class SyncProjector implements Projector
{
    /** @var Projection[] */
    private array $projections = [];

    /** @param Projection[] $projections */
    public function register(array $projections): void
    {
        foreach ($projections as $projection) {
            $listensTo = $projection->listensTo();
            $this->projections[$listensTo] = $projection;
        }
    }

    /** @param DomainEvent[] $events */
    public function project(array $events): void
    {
        foreach ($events as $event) {
            if (isset($this->projections[get_class($event)])) {
                $this
                    ->projections[get_class($event)]
                    ->project($event);
            }
        }
    }
}
