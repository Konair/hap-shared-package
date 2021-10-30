<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\Name\Validator\LastNameValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class LastNameTest extends TestCase
{
    public function testLastNameToCreate(): void
    {
        // when
        $lastName = new LastName('MyLastName', new LastNameValidator());

        // then
        $this->assertInstanceOf(LastName::class, $lastName);
    }

    public function testLastNameToCreateWithFactoryMethod(): void
    {
        // when
        $lastName = LastName::create('MyLastName');

        // then
        $this->assertInstanceOf(LastName::class, $lastName);
    }

    public function testLastNameEquality(): void
    {
        // given
        $lastName1 = LastName::create('MyLastName');
        $lastName2 = LastName::create('MyLastName');

        // when
        $isEqual = $lastName1->equalsTo($lastName2);

        // then
        $this->assertTrue($isEqual);
    }

    public function testLastNameInequality(): void
    {
        // given
        $lastName1 = LastName::create('MyLastName');
        $lastName2 = LastName::create('MyOtherLastName');

        // when
        $isEqual = $lastName1->equalsTo($lastName2);

        // then
        $this->assertFalse($isEqual);
    }

    public function testInvalidLastName(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        LastName::create(null);
    }

    public function testLastNameToCastToString(): void
    {
        // given
        $lastName = LastName::create('MyLastName');

        // when
        $lastNameValue = (string)$lastName;

        // then
        $this->assertIsString($lastNameValue);
    }

    public function testLastNameValue(): void
    {
        // given
        $lastName = LastName::create('MyLastName');

        // then
        $this->assertSame('MyLastName', $lastName->value());
    }
}
