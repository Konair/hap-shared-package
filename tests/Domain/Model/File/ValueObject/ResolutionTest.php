<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class ResolutionTest extends TestCase
{
    public function testResolutionToCreate(): void
    {
        // given
        $width = $height = 100;

        // when
        $resolution = Resolution::create($width, $height);

        // then
        $this->assertInstanceOf(Resolution::class, $resolution);
    }

    public function testResolutionToCreateWithZeroWidthAndHeight(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = $height = 0;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithZeroHeight(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = 100;
        $height = 0;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithZeroWith(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = 0;
        $height = 100;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithNegativeWith(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = -100;
        $height = 100;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithNegativeHeight(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = 100;
        $height = -100;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithoutWidth(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = null;
        $height = 100;

        // when
        Resolution::create($width, $height);
    }

    public function testResolutionToCreateWithoutHeight(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        $width = 100;
        $height = null;

        // when
        Resolution::create($width, $height);
    }
}
