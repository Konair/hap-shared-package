<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model;

use Carbon\CarbonImmutable;
use Konair\HAP\Shared\Domain\Model\DomainEvent\DomainEvent;

final class PenColorChanged implements DomainEvent
{
    private PenId $penId;
    private string $penColor;
    private CarbonImmutable $occurredOn;

    public function __construct(PenId $penId, string $penColor)
    {
        $this->penId = $penId;
        $this->penColor = $penColor;
        $this->occurredOn = CarbonImmutable::now();
    }

    public function penId(): PenId
    {
        return $this->penId;
    }

    public function penColor(): string
    {
        return $this->penColor;
    }

    public function occurredOn(): CarbonImmutable
    {
        return $this->occurredOn;
    }
}
