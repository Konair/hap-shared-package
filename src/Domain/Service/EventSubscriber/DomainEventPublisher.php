<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Service\EventSubscriber;

use BadMethodCallException;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;
use Konair\HAP\Shared\Domain\Model\Identification\Identification;

final class DomainEventPublisher
{
    /** @var DomainEventSubscriber[] */
    private array $subscribers = [];

    private static ?DomainEventPublisher $instance = null;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function __clone()
    {
        throw new BadMethodCallException('Clone is not supported');
    }

    public function subscribe(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(Identification $identification, DomainEvent $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($identification, $event);
            }
        }
    }
}
