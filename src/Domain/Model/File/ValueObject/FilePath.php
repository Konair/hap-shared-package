<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\File\Validator\FilePathValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class FilePath implements ValueObject, Stringable
{
    private string $path;

    public static function create(string|null $path, ?Validator $validator = null): self
    {
        return new self($path, $validator ?: new FilePathValidator());
    }

    public function __construct(string|null $path, Validator $validator)
    {
        $validator->validate($path);

        if (!$validator->isValid() || is_null($path)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->path = $path;
    }

    public function value(): string
    {
        return $this->path;
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
