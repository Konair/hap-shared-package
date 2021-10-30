<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Address\Validator\LineValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Line implements ValueObject, Stringable
{
    private string $line;

    public static function create(string|null $line, ?Validator $validator = null): self
    {
        return new self($line, $validator ?: new LineValidator());
    }

    public function __construct(string|null $line, Validator $validator)
    {
        $validator->validate($line);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->line = (string)$line;
    }

    public function value(): string
    {
        return $this->line;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->line;
    }
}
