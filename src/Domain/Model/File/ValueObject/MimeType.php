<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\File\Validator\MimeTypeValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class MimeType implements ValueObject, Stringable
{
    private string $mimeType;

    public static function create(string|null $mimeType, ?Validator $validator = null): self
    {
        return new self($mimeType, $validator ?: new MimeTypeValidator());
    }

    public function __construct(string|null $mimeType, Validator $validator)
    {
        $validator->validate($mimeType);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->mimeType = (string)$mimeType;
    }

    public function value(): string
    {
        return $this->mimeType;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->mimeType;
    }
}
