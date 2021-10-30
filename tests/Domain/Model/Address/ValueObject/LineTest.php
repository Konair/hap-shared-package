<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class LineTest extends TestCase
{
    public function testStringableLine(): void
    {
        // given
        $line = Line::create('Nothing Here street 69.');

        // when
        $string = (string)$line;

        // then
        $this->assertIsString($string);
    }

    public function testLineWithInvalidValue(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        Line::create(null);
    }
}
