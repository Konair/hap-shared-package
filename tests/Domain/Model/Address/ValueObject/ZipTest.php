<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class ZipTest extends TestCase
{
    public function testStringableZip(): void
    {
        // given
        $zip = Zip::create('1234-A');

        // when
        $string = (string)$zip;

        // then
        $this->assertIsString($string);
    }

    public function testZipWithInvalidValue(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // when
        Zip::create(null);
    }
}
