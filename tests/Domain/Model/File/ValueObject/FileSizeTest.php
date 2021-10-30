<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class FileSizeTest extends TestCase
{
    public function testFactoryMethod(): void
    {
        // given
        $size = 1024;

        // when
        $size = FileSize::create($size);

        // then
        $this->assertInstanceOf(FileSize::class, $size);
    }

    public function testInvalidationOfSize(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $size = -1024;

        // when
        FileSize::create($size);
    }

    public function testEqualityOfSizes(): void
    {
        // given
        $size1 = FileSize::create(1024);
        $size2 = FileSize::create(1024);

        // when
        $isEquals = $size1->equalsTo($size2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testInequalityOfEmailAddresses(): void
    {
        // given
        $size1 = FileSize::create(1024);
        $size2 = FileSize::create(2048);

        // when
        $isEquals = $size1->equalsTo($size2);

        // then
        $this->assertFalse($isEquals);
    }

    public function testSizeToCastToString(): void
    {
        // given
        $size = FileSize::create(1024);

        // when
        $sizeValue = (string)$size;

        // then
        $this->assertSame('1024', $sizeValue);
    }
}
