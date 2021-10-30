<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection\ArrayCollection;

use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

/**
 * @template TKey
 * @template T of ValueObjectCollection
 * @template TElement of ValueObject
 * @extends ImmutableArrayCollection<TKey|null, T, TElement>
 * @property ValueObject[] $elements
 */
abstract class ValueObjectCollection extends ImmutableArrayCollection
{
    /**
     * {@inheritDoc}
     */
    final public function removeElement(mixed $element): static
    {
        $newElements = $this->elements;
        foreach ($newElements as $key => $newElement) {
            if ($newElement->equalsTo($element)) {
                unset($newElements[$key]);
            }
        }

        return new static(...$newElements);
    }
}
