<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Address\Validator\CityValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class City implements ValueObject, Stringable
{
    private string $city;

    public static function create(string|null $city, ?Validator $validator = null): self
    {
        return new self($city, $validator ?: new CityValidator());
    }

    public function __construct(string|null $city, Validator $validator)
    {
        $validator->validate($city);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->city = (string)$city;
    }

    public function value(): string
    {
        return $this->city;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->city;
    }
}
