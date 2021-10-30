<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Infrastructure\Domain\Service\EventSubscriber\Spy;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\PenColorChanged;
use Konair\HAP\Shared\Domain\Model\PenId;

final class SpySubscriberTest extends TestCase
{
    public function testSubscribing(): void
    {
        $penId = PenId::create();
        $subscriber = new SpySubscriber();
        $event = new PenColorChanged($penId, 'red');
        $isSubscribed = $subscriber->isSubscribedTo($event);
        $subscriber->handle($penId, $event);

        $this->assertTrue($isSubscribed);
        $this->assertCount(1, $subscriber->events());
    }
}
