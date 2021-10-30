<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Address\Validator\ZipValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Zip implements ValueObject, Stringable
{
    private string $zip;

    public static function create(string|null $zip, ?Validator $validator = null): self
    {
        return new self($zip, $validator ?: new ZipValidator());
    }

    public function __construct(string|null $zip, Validator $validator)
    {
        $validator->validate($zip);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->zip = (string)$zip;
    }

    public function value(): string
    {
        return $this->zip;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->zip;
    }
}
