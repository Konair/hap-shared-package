<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class AddressTest extends TestCase
{
    public function testAddress(): void
    {
        $country = 'Hungary';
        $zip = '1234';
        $city = 'Budapest';
        $line = 'Nothing Here street 69.';

        $address = new Address(
            Country::create($country),
            Zip::create($zip),
            City::create($city),
            Line::create($line)
        );

        $this->assertSame($country, $address->country()->value());
        $this->assertSame($zip, $address->zip()->value());
        $this->assertSame($city, $address->city()->value());
        $this->assertSame($line, $address->line()->value());
    }

    public function testEmptyCountry(): void
    {
        $this->expectException(ValidationException::class);

        $country = '';
        $zip = '1234';
        $city = 'Budapest';
        $line = 'Nothing Here street 69.';

        new Address(
            Country::create($country),
            Zip::create($zip),
            City::create($city),
            Line::create($line)
        );
    }

    public function testNullCountry(): void
    {
        $this->expectException(ValidationException::class);

        $country = null;
        $zip = '1234';
        $city = 'Budapest';
        $line = 'Nothing Here street 69.';

        new Address(
            Country::create($country),
            Zip::create($zip),
            City::create($city),
            Line::create($line)
        );
    }

    public function testEqualityOfAddresses(): void
    {
        // given
        $country = 'Hungary';
        $zip = '1234';
        $city = 'Budapest';
        $line = 'Nothing Here street 69.';

        $address1 = new Address(
            Country::create($country),
            Zip::create($zip),
            City::create($city),
            Line::create($line)
        );

        $address2 = new Address(
            Country::create($country),
            Zip::create($zip),
            City::create($city),
            Line::create($line)
        );

        // when
        $isEquals = $address1->equalsTo($address2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testInequalityOfAddresses(): void
    {
        $country1 = 'Hungary';
        $zip1 = '1234';
        $city1 = 'Budapest';
        $line1 = 'Nothing Here street 69.';

        $country2 = 'Hungary';
        $zip2 = '4321';
        $city2 = 'Budapest';
        $line2 = 'Nothing Here street 69.';

        $address1 = new Address(
            Country::create($country1),
            Zip::create($zip1),
            City::create($city1),
            Line::create($line1)
        );

        $address2 = new Address(
            Country::create($country2),
            Zip::create($zip2),
            City::create($city2),
            Line::create($line2)
        );

        $this->assertFalse($address1->equalsTo($address2));
    }

    public function testAddressCreationWithFactoryMethod(): void
    {
        // given
        $country = Country::create('Hungary');
        $zip = Zip::create('1234');
        $city = City::create('Budapest');
        $line = Line::create('Nothing Here street 69.');

        // when
        $address = Address::create($country, $zip, $city, $line);

        // then
        $this->assertInstanceOf(Address::class, $address);
    }

    public function testStringableAddress(): void
    {
        // given
        $country = Country::create('Hungary');
        $zip = Zip::create('1234');
        $city = City::create('Budapest');
        $line = Line::create('Nothing Here street 69.');

        // when
        $address = (string)Address::create($country, $zip, $city, $line);

        // then
        $this->assertIsString($address);
    }
}
