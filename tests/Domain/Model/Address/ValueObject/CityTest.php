<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class CityTest extends TestCase
{
    public function testStringableCity(): void
    {
        // given
        $city = City::create('1234-A');

        // when
        $string = (string)$city;

        // then
        $this->assertIsString($string);
    }

    public function testCityWithInvalidValue(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        City::create(null);
    }
}
