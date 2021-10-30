<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\ValueObject;

interface ValueObject
{
    public function equalsTo(ValueObject $valueObject): bool;
}
