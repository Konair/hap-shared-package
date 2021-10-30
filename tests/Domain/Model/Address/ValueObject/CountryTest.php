<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use PHPUnit\Framework\TestCase;

final class CountryTest extends TestCase
{
    public function testStringableCountry(): void
    {
        // given
        $country = Country::create('Hungary');

        // when
        $string = (string)$country;

        // then
        $this->assertIsString($string);
    }
}
