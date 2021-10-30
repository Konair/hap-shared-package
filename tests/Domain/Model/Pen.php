<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model;

use Konair\HAP\Shared\Domain\Model\Entity\AggregateRoot;
use Konair\HAP\Shared\Domain\Model\Entity\EventSourcedAggregateRoot;
use Konair\HAP\Shared\Domain\Model\Entity\Exception\WrongIdentificationTypeException;
use Konair\HAP\Shared\Domain\Model\EventStore\EventStream;

/**
 * @extends AggregateRoot<PenId>
 */
final class Pen extends AggregateRoot implements EventSourcedAggregateRoot
{
    private string|null $color = null;

    public static function reconstitute(EventStream $history): Pen
    {
        $penId = $history->aggregateId();

        if (!$penId instanceof PenId) {
            throw new WrongIdentificationTypeException();
        }

        $pen = new self($penId);

        foreach ($history->events() as $event) {
            $pen->applyThat($event);
        }

        return $pen;
    }

    public function __construct(
        private PenId $identification,
    ) {
    }

    // Getters

    public function identification(): PenId
    {
        return $this->identification;
    }

    public function color(): ?string
    {
        return $this->color;
    }

    // Modifiers

    public function changeColor(string $color): void
    {
        $this->recordApplyAndPublishThat(
            new PenColorChanged(
                $this->identification,
                $color
            )
        );
    }

    // Event appliers

    protected function applyPenColorChanged(PenColorChanged $event): void
    {
        $this->color = $event->penColor();
    }
}
