<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Service\EventSubscriber;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

final class DomainEventPublisherTest extends TestCase
{
    public function testDomainEventPublisherToCreate(): void
    {
        // when
        $instance = DomainEventPublisher::instance();

        // then
        $this->assertInstanceOf(DomainEventPublisher::class, $instance);
    }

    public function testDomainEventPublisherToClone(): void
    {
        // then
        $this->expectException(BadMethodCallException::class);

        // given
        $instance = DomainEventPublisher::instance();

        // when
        (clone $instance);
    }
}
