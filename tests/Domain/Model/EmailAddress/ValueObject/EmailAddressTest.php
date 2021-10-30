<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EmailAddress\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class EmailAddressTest extends TestCase
{
    public function testFactoryMethod(): void
    {
        // given
        $emailAddress = 'name@domain.tld';

        // when
        $emailAddress = EmailAddress::create($emailAddress);

        // then
        $this->assertInstanceOf(EmailAddress::class, $emailAddress);
    }

    public function testInvalidationEmailAddress(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $emailAddress = 'word';

        // when
        EmailAddress::create($emailAddress);
    }

    public function testEqualityOfEmailAddresses(): void
    {
        // given
        $emailAddress1 = EmailAddress::create('name@domain.tld');
        $emailAddress2 = EmailAddress::create('name@domain.tld');

        // when
        $isEquals = $emailAddress1->equalsTo($emailAddress2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testInequalityOfEmailAddresses(): void
    {
        // given
        $emailAddress1 = EmailAddress::create('name@domain.tld');
        $emailAddress2 = EmailAddress::create('work@domain.tld');

        // when
        $isEquals = $emailAddress1->equalsTo($emailAddress2);

        // then
        $this->assertFalse($isEquals);
    }

    public function testEmailAddressToCastToString(): void
    {
        // given
        $emailAddress = EmailAddress::create('name@domain.tld');

        // when
        $emailAddressValue = (string)$emailAddress;

        // then
        $this->assertSame('name@domain.tld', $emailAddressValue);
    }
}
