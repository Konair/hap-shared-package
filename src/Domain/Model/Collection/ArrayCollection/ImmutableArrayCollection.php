<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection\ArrayCollection;

use ArrayIterator;
use Exception;
use Konair\HAP\Shared\Domain\Model\Collection\Collection;

/**
 * @template TKey
 * @template T of ImmutableArrayCollection
 * @template TElement of object
 * @template-implements Collection<TKey, T, TElement>
 */
abstract class ImmutableArrayCollection implements Collection
{
    use CountableMethods;

    /** @var TElement[] */
    protected array $elements = [];

    /**
     * @param TElement ...$elements
     */
    final public function __construct(mixed ...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * {@inheritDoc}
     */
    final public function append(mixed $element): static
    {
        return new static(...$this->elements, ...[$element]);
    }

    /**
     * {@inheritDoc}
     */
    final public function remove(mixed $key): static
    {
        $newElements = $this->elements;
        if ($this->offsetExists($key)) {
            unset($newElements[$key]);
        }

        return new static(...$newElements);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    // Required by interface ArrayAccess.

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritDoc}
     * @param TKey $offset
     */
    final public function offsetExists(mixed $offset): bool
    {
        return isset($this->elements[$offset]);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritDoc}
     * @param TKey $offset
     * @return TElement|null
     */
    final public function offsetGet(mixed $offset): mixed
    {
        return $this->elements[$offset] ?? null;
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritDoc}
     * @param TKey $offset
     * @throws Exception
     */
    final public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new Exception();
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritDoc}
     * @param TKey $offset
     * @throws Exception
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new Exception();
    }

    // Required by interface IteratorAggregate.

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritDoc}
     * @return ArrayIterator<array-key, TElement>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }
}
