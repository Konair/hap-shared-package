<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection;

use Exception;
use stdClass;
use PHPUnit\Framework\TestCase;

final class ImmutableCollectionTest extends TestCase
{
    public function testCollectionAppending(): void
    {
        $collectionA = new FakeImmutableArrayCollection(
            new stdClass(),
            new stdClass(),
            new stdClass(),
            new stdClass(),
            new stdClass(),
        );
        $collectionB = $collectionA->append(
            new stdClass()
        );

        $this->assertNotSame($collectionA, $collectionB);
        $this->assertCount(5, $collectionA);
        $this->assertCount(6, $collectionB);
        $this->assertFalse($collectionA->isEmpty());
        $this->assertFalse($collectionB->isEmpty());
    }

    public function testByDefaultEmptyCollection(): void
    {
        $collection = new FakeImmutableArrayCollection();

        $this->assertTrue($collection->isEmpty());
    }

    public function testImmutabilityByDeletion(): void
    {
        // given
        $collection = new FakeImmutableArrayCollection(
            new stdClass(),
            new stdClass(),
        );

        // when
        $collection->remove(1);

        // then
        $this->assertCount(2, $collection);
    }

    public function testImmutabilityByDeletion2(): void
    {
        // given
        $element = new stdClass();
        $collection = new FakeImmutableArrayCollection(
            new stdClass(),
            $element,
        );

        // when
        $collection->removeElement($element);

        // then
        $this->assertCount(2, $collection);
    }

    public function testOffsetSet(): void
    {
        // then
        $this->expectException(Exception::class);

        // given
        $element = new stdClass();
        $collection = new FakeImmutableArrayCollection();

        // when
        $collection->offsetSet(0, $element);
    }

    public function testOffsetUnset(): void
    {
        // then
        $this->expectException(Exception::class);

        // given
        $collection = new FakeImmutableArrayCollection(new stdClass());

        // when
        $collection->offsetUnset(0);
    }

    public function testOffsetExists(): void
    {
        // given
        $collection = new FakeImmutableArrayCollection(new stdClass());

        // when
        $isExists = $collection->offsetExists(0);

        // then
        $this->assertTrue($isExists);
    }

    public function testCollectionToRemoveAElementByIndex(): void
    {
        // given
        $collection = new FakeImmutableArrayCollection(
            new stdClass(),
            new stdClass(),
        );

        // when
        $newCollection = $collection->remove(1);

        // then
        $this->assertCount(1, $newCollection);
    }

    public function testCollectionToRemoveAElementByElement(): void
    {
        // given
        $element = new stdClass();
        $collection = new FakeImmutableArrayCollection(
            new stdClass(),
            $element,
        );

        // when
        $newCollection = $collection->removeElement($element);

        // then
        $this->assertCount(1, $newCollection);
    }
}
