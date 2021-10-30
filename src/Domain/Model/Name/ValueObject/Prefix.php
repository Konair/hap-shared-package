<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\Name\Validator\PrefixValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Prefix implements ValueObject, Stringable
{
    private string $prefix;

    public static function create(string|null $prefix, ?Validator $validator = null): self
    {
        return new self($prefix, $validator ?: new PrefixValidator());
    }

    public function __construct(string|null $prefix, Validator $validator)
    {
        $validator->validate($prefix);

        if (!$validator->isValid() || is_null($prefix)) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->prefix = $prefix;
    }

    public function value(): string
    {
        return $this->prefix;
    }

    public function equalsTo(ValueObject|null $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->prefix;
    }
}
