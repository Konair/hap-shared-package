<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\DomainEvent;

use Konair\HAP\Shared\Domain\Model\Collection\ArrayCollection\ImmutableArrayCollection;

/**
 * @extends ImmutableArrayCollection<int, DomainEventCollection, DomainEvent>
 */
final class DomainEventCollection extends ImmutableArrayCollection
{
    /**
     * {@inheritDoc}
     */
    public function removeElement(mixed $element): self
    {
        $newElements = $this->elements;

        if ($element instanceof DomainEvent) {
            foreach ($newElements as $key => $newElement) {
                if ($element->occurredOn() === $newElement->occurredOn()) {
                    unset($newElements[$key]);
                }
            }
        }

        return new self(...$newElements);
    }
}
