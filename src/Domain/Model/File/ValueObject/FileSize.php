<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\File\Validator\FileSizeValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class FileSize implements ValueObject, Stringable
{
    private int $size;

    public static function create(int|null $size, ?Validator $validator = null): self
    {
        return new self($size, $validator ?: new FileSizeValidator());
    }

    public function __construct(int|null $size, Validator $validator)
    {
        $validator->validate($size);

        if (!$validator->isValid() || is_null($size)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->size = $size;
    }

    public function value(): int
    {
        return $this->size;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return strval($this->value());
    }
}
