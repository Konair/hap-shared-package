<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\File\Validator\ResolutionValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Resolution implements ValueObject, Stringable, JsonSerializable
{
    private int $width;
    private int $height;

    public static function create(int|null $width, int|null $height, Validator|null $validator = null): self
    {
        return new self($width, $height, $validator ?: new ResolutionValidator());
    }

    public function __construct(
        int|null $width,
        int|null $height,
        Validator $validator,
    ) {
        $validator->validate([
            'width' => $width,
            'height' => $height,
        ]);

        if (!$validator->isValid() || is_null($width) || is_null($height)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->width = $width;
        $this->height = $height;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->width() === $this->width()
            && $valueObject->height() === $this->height();
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'width' => $this->width,
            'height' => $this->height,
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
