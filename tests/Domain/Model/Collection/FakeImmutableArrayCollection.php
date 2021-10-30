<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection;

use Konair\HAP\Shared\Domain\Model\Collection\ArrayCollection\ImmutableArrayCollection;

/**
 * @extends ImmutableArrayCollection<int, FakeImmutableArrayCollection, \stdClass>
 */
final class FakeImmutableArrayCollection extends ImmutableArrayCollection
{
    /**
     * {@inheritDoc}
     */
    public function removeElement(mixed $element): static
    {
        $newElements = $this->elements;
        foreach ($newElements as $key => $newElement) {
            if ($element === $newElement) {
                unset($newElements[$key]);
            }
        }

        return new static(...$newElements);
    }
}
