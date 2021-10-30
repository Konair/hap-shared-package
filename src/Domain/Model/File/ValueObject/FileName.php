<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\File\Validator\FileNameValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class FileName implements ValueObject, Stringable
{
    private string $fileName;

    public static function create(string|null $fileName, ?Validator $validator = null): self
    {
        return new self($fileName, $validator ?: new FileNameValidator());
    }

    public function __construct(string|null $fileName, Validator $validator)
    {
        $validator->validate($fileName);

        if (!$validator->isValid() || is_null($fileName)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->fileName = $fileName;
    }

    public function value(): string
    {
        return $this->fileName;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
