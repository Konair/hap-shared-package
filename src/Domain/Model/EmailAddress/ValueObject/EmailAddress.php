<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EmailAddress\ValueObject;

use Stringable;
use Konair\HAP\Shared\Domain\Model\EmailAddress\Validator\EmailAddressValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class EmailAddress implements ValueObject, Stringable
{
    private string $emailAddress;

    public static function create(string|null $emailAddress, ?Validator $validator = null): self
    {
        return new self($emailAddress, $validator ?: new EmailAddressValidator());
    }

    public function __construct(string|null $emailAddress, Validator $validator)
    {
        $validator->validate($emailAddress);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->emailAddress = (string)$emailAddress;
    }

    public function value(): string
    {
        return $this->emailAddress;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }
}
