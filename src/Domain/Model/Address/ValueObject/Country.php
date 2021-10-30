<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Address\Validator\CountryValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Country implements ValueObject, Stringable
{
    private string $country;

    public static function create(string|null $country, ?Validator $validator = null): self
    {
        return new self($country, $validator ?: new CountryValidator());
    }

    public function __construct(string|null $country, Validator $validator)
    {
        $validator->validate($country);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->country = (string)$country;
    }

    public function value(): string
    {
        return $this->country;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->country;
    }
}
