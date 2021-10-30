<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\Language\ValueObject\Language;
use Konair\HAP\Shared\Domain\Model\Name\Exception\UnknownFullNameFormatException;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Name implements ValueObject, Stringable, JsonSerializable
{
    public static function create(Prefix|null $prefix, FirstName $firstName, LastName $lastName): self
    {
        return new self($prefix, $firstName, $lastName);
    }

    public function __construct(
        private Prefix|null $prefix,
        private FirstName $firstName,
        private LastName $lastName,
    ) {
    }

    public function prefix(): Prefix|null
    {
        return $this->prefix;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function fullName(Language $language): string
    {
        $fistNameToFirstPlace = match ($language->twoLetterISOCode()) {
            'de' => true,
            'hu' => false,
            default => throw new UnknownFullNameFormatException(),
        };

        $prefix = is_null($this->prefix) ? '' : $this->prefix->value();

        return $fistNameToFirstPlace
            ? implode(' ', [$prefix, $this->firstName->value(), $this->lastName->value()])
            : implode(' ', [$prefix, $this->lastName->value(), $this->firstName->value()]);
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && (
                (is_null($valueObject->prefix()) && is_null($this->prefix()))
                || ($valueObject->prefix()?->equalsTo($this->prefix()) === true)
            )
            && $valueObject->firstName()->equalsTo($this->firstName())
            && $valueObject->lastName()->equalsTo($this->lastName());
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'prefix' => $this->prefix?->value(),
            'firstName' => $this->firstName->value(),
            'lastName' => $this->lastName->value(),
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
