<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EventStore\ValueObject;

use PHPUnit\Framework\TestCase;

final class StoredEventIdTest extends TestCase
{
    public function testStoredEventIdCreation(): void
    {
        // when
        $storedEventId = new StoredEventId();

        //then
        $this->assertInstanceOf(StoredEventId::class, $storedEventId);
    }

    public function testStoredEventIdCreationWithFactoryMethod(): void
    {
        // when
        $storedEventId = StoredEventId::create();

        //then
        $this->assertInstanceOf(StoredEventId::class, $storedEventId);
    }
}
