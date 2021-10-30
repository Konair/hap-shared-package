<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Name\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\Name\Validator\PrefixValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class PrefixTest extends TestCase
{
    public function testPrefixToCreate(): void
    {
        // when
        $prefix = new Prefix('MyPrefix', new PrefixValidator());

        // then
        $this->assertInstanceOf(Prefix::class, $prefix);
    }

    public function testPrefixToCreateWithFactoryMethod(): void
    {
        // when
        $prefix = Prefix::create('MyPrefix');

        // then
        $this->assertInstanceOf(Prefix::class, $prefix);
    }

    public function testPrefixEquality(): void
    {
        // given
        $prefix1 = Prefix::create('MyPrefix');
        $prefix2 = Prefix::create('MyPrefix');

        // when
        $isEqual = $prefix1->equalsTo($prefix2);

        // then
        $this->assertTrue($isEqual);
    }

    public function testPrefixInequality(): void
    {
        // given
        $prefix1 = Prefix::create('MyPrefix');
        $prefix2 = Prefix::create('MyOtherPrefix');

        // when
        $isEqual = $prefix1->equalsTo($prefix2);

        // then
        $this->assertFalse($isEqual);
    }

    public function testInvalidPrefix(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        Prefix::create(null);
    }

    public function testPrefixToCastToString(): void
    {
        // given
        $prefix = Prefix::create('MyPrefix');

        // when
        $prefixValue = (string)$prefix;

        // then
        $this->assertIsString($prefixValue);
    }

    public function testPrefixValue(): void
    {
        // given
        $prefix = Prefix::create('MyPrefix');

        // then
        $this->assertSame('MyPrefix', $prefix->value());
    }
}
