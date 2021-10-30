<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Identification;

use Ramsey\Uuid\Uuid;
use Stringable;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

abstract class Identification implements ValueObject, Stringable
{
    protected string $identification;

    public static function create(string|null $identification = null): static
    {
        return new static($identification);
    }

    final public function __construct(string|null $identification = null)
    {
        $this->setIdentification($identification);
    }

    protected function setIdentification(string|null $identification): void
    {
        if (!$identification) {
            $identification = Uuid::uuid4()->toString();
        }

        $this->identification = (string)$identification;
    }

    final public function value(): string
    {
        return $this->identification;
    }

    final public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->identification;
    }

    final public function __toString(): string
    {
        return $this->value();
    }
}
