<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\Language\ValueObject\Language;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class NameTest extends TestCase
{
    public function testNullPrefix(): void
    {
        $this->expectException(ValidationException::class);

        $prefix = null;
        $firstName = 'FName';
        $lastName = 'LName';
        $name = new Name(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        $this->assertNull($name->prefix());
        $this->assertSame($firstName, $name->firstName()->value());
        $this->assertSame($lastName, $name->lastName()->value());
    }

    public function testEmptyPrefix(): void
    {
        $this->expectException(ValidationException::class);

        $prefix = '';
        $firstName = 'FName';
        $lastName = 'LName';
        $name = new Name(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        $this->assertNull($name->prefix());
        $this->assertSame($firstName, $name->firstName()->value());
        $this->assertSame($lastName, $name->lastName()->value());
    }

    public function testEmptyFirstName(): void
    {
        $this->expectException(ValidationException::class);

        $firstName = '';
        $lastName = 'LName';
        new Name(
            null,
            FirstName::create($firstName),
            LastName::create($lastName)
        );
    }

    public function testNullFirstName(): void
    {
        $this->expectException(ValidationException::class);

        $firstName = null;
        $lastName = 'LName';
        new Name(
            null,
            FirstName::create($firstName),
            LastName::create($lastName)
        );
    }

    public function testEmptyLastName(): void
    {
        $this->expectException(ValidationException::class);

        $firstName = 'FName';
        $lastName = '';
        new Name(
            null,
            FirstName::create($firstName),
            LastName::create($lastName)
        );
    }

    public function testNullLastName(): void
    {
        $this->expectException(ValidationException::class);

        $firstName = 'FName';
        $lastName = null;
        new Name(
            null,
            FirstName::create($firstName),
            LastName::create($lastName)
        );
    }

    public function testWithPrefix(): void
    {
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name = new Name(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        $this->assertNotNull($name->prefix());
        $this->assertSame($prefix, $name->prefix()->value());
        $this->assertSame($firstName, $name->firstName()->value());
        $this->assertSame($lastName, $name->lastName()->value());
    }

    public function testFullNameWithHungarianFormat(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name = new Name(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // when
        $fullName = $name->fullName(Language::HU());

        $this->assertIsString($fullName);
        $this->assertSame('NamePrefix LName FName', $fullName);
    }

    public function testFullNameWithHGermanFormat(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name = new Name(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // when
        $fullName = $name->fullName(Language::DE());

        $this->assertIsString($fullName);
        $this->assertSame('NamePrefix FName LName', $fullName);
    }

    public function testNameToCreateWithFactoryMethod(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';

        // when
        $name = Name::create(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // then
        $this->assertInstanceOf(Name::class, $name);
    }

    public function testNameToCastToString(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name = Name::create(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // when
        $nameValue = (string)$name;

        // then
        $this->assertIsString($nameValue);
    }

    public function testNameEquality(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name1 = Name::create(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );
        $name2 = Name::create(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // when
        $isEquals = $name1->equalsTo($name2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testNameInequalityWithoutPrefix(): void
    {
        // given
        $prefix = 'NamePrefix';
        $firstName = 'FName';
        $lastName = 'LName';
        $name1 = Name::create(
            null,
            FirstName::create($firstName),
            LastName::create($lastName)
        );
        $name2 = Name::create(
            Prefix::create($prefix),
            FirstName::create($firstName),
            LastName::create($lastName)
        );

        // when
        $isEquals1 = $name1->equalsTo($name2);
        $isEquals2 = $name2->equalsTo($name1);

        // then
        $this->assertFalse($isEquals1);
        $this->assertFalse($isEquals2);
    }
}
