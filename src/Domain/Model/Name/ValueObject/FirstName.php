<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Name\Validator\FirstNameValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class FirstName implements ValueObject, Stringable
{
    private string $firstName;

    public static function create(string|null $firstName, ?Validator $validator = null): self
    {
        return new self($firstName, $validator ?: new FirstNameValidator());
    }

    public function __construct(string|null $firstName, Validator $validator)
    {
        $validator->validate($firstName);

        if (!$validator->isValid() || is_null($firstName)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->firstName = $firstName;
    }

    public function value(): string
    {
        return $this->firstName;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->firstName;
    }
}
