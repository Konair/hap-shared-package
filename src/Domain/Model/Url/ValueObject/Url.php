<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Url\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Url\Validator\UrlValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Url implements ValueObject, Stringable
{
    private string $url;

    public static function create(string|null $url, ?Validator $validator = null): self
    {
        return new self($url, $validator ?: new UrlValidator());
    }

    public function __construct(string|null $url, Validator $validator)
    {
        $validator->validate($url);

        if (!$validator->isValid() || is_null($url)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->url = $url;
    }

    public function value(): string
    {
        return $this->url;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
