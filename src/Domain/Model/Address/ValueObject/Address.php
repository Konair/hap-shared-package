<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Address implements ValueObject, Stringable, JsonSerializable
{
    public static function create(Country $country, Zip $zip, City $city, Line $line): self
    {
        return new self($country, $zip, $city, $line);
    }

    public function __construct(
        private Country $country,
        private Zip $zip,
        private City $city,
        private Line $line,
    ) {
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function zip(): Zip
    {
        return $this->zip;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function line(): Line
    {
        return $this->line;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $this->country()->equalsTo($valueObject->country())
            && $this->zip()->equalsTo($valueObject->zip())
            && $this->city()->equalsTo($valueObject->city())
            && $this->line()->equalsTo($valueObject->line());
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'country' => $this->country->value(),
            'zip' => $this->zip->value(),
            'city' => $this->city->value(),
            'line' => $this->line->value(),
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
