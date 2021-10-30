<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template TKey
 * @template T of Collection
 * @template TElement of object
 * @template-extends IteratorAggregate<TKey, TElement>
 * @template-extends ArrayAccess<TKey, TElement>
 */
interface Collection extends IteratorAggregate, ArrayAccess, Countable
{
    /**
     * @param TElement $element
     * @return T<TKey, T, TElement>
     */
    public function append(mixed $element): self;

    /**
     * @param TKey $key
     * @return T<TKey, T, TElement>
     */
    public function remove(mixed $key): self;

    /**
     * @param TElement $element
     * @return T<TKey, T, TElement>
     */
    public function removeElement(mixed $element): self;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
}
