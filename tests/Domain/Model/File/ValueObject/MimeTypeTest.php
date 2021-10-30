<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class MimeTypeTest extends TestCase
{
    public function testFactoryMethod(): void
    {
        // given
        $mimeType = 'image/png';

        // when
        $mimeType = MimeType::create($mimeType);

        // then
        $this->assertInstanceOf(MimeType::class, $mimeType);
    }

    public function testInvalidationOfMimeType(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $mimeType = 'word';

        // when
        MimeType::create($mimeType);
    }

    public function testEqualityOfMimeTypes(): void
    {
        // given
        $mimeType1 = MimeType::create('image/png');
        $mimeType2 = MimeType::create('image/png');

        // when
        $isEquals = $mimeType1->equalsTo($mimeType2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testInequalityOfEmailAddresses(): void
    {
        // given
        $mimeType1 = MimeType::create('image/png');
        $mimeType2 = MimeType::create('image/jpeg');

        // when
        $isEquals = $mimeType1->equalsTo($mimeType2);

        // then
        $this->assertFalse($isEquals);
    }

    public function testMimeTypeToCastToString(): void
    {
        // given
        $mimeType = MimeType::create('image/png');

        // when
        $mimeTypeValue = (string)$mimeType;

        // then
        $this->assertSame('image/png', $mimeTypeValue);
    }
}
