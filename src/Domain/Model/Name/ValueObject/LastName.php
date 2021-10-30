<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Name\Validator\LastNameValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class LastName implements ValueObject, Stringable
{
    private string $lastName;

    public static function create(string|null $lastName, ?Validator $validator = null): self
    {
        return new self($lastName, $validator ?: new LastNameValidator());
    }

    public function __construct(string|null $lastName, Validator $validator)
    {
        $validator->validate($lastName);

        if (!$validator->isValid() || is_null($lastName)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->lastName = $lastName;
    }

    public function value(): string
    {
        return $this->lastName;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->lastName;
    }
}
