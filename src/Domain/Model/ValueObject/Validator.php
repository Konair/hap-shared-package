<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\ValueObject;

interface Validator
{
    public function validate(mixed $value): void;

    public function isValid(): bool;

    /** @return string[] */
    public function getErrorMessages(): array;
}
