<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\Name\Validator\FirstNameValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class FirstNameTest extends TestCase
{
    public function testFirstNameToCreate(): void
    {
        // when
        $firstName = new FirstName('MyFirstName', new FirstNameValidator());

        // then
        $this->assertInstanceOf(FirstName::class, $firstName);
    }

    public function testFirstNameToCreateWithFactoryMethod(): void
    {
        // when
        $firstName = FirstName::create('MyFirstName');

        // then
        $this->assertInstanceOf(FirstName::class, $firstName);
    }

    public function testFirstNameEquality(): void
    {
        // given
        $firstName1 = FirstName::create('MyFirstName');
        $firstName2 = FirstName::create('MyFirstName');

        // when
        $isEqual = $firstName1->equalsTo($firstName2);

        // then
        $this->assertTrue($isEqual);
    }

    public function testFirstNameInequality(): void
    {
        // given
        $firstName1 = FirstName::create('MyFirstName');
        $firstName2 = FirstName::create('MyOtherFirstName');

        // when
        $isEqual = $firstName1->equalsTo($firstName2);

        // then
        $this->assertFalse($isEqual);
    }

    public function testInvalidFirstName(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        FirstName::create(null);
    }

    public function testFirstNameToCastToString(): void
    {
        // given
        $firstName = FirstName::create('MyFirstName');

        // when
        $firstNameValue = (string)$firstName;

        // then
        $this->assertIsString($firstNameValue);
    }

    public function testFirstNameValue(): void
    {
        // given
        $firstName = FirstName::create('MyFirstName');

        // then
        $this->assertSame('MyFirstName', $firstName->value());
    }
}
