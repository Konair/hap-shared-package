<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Identification;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\PenId;

final class IdentificationTest extends TestCase
{
    public function testIdentificationCreation(): void
    {
        // when
        $penId = new PenId();

        //then
        $this->assertInstanceOf(PenId::class, $penId);
    }

    public function testIdentificationCreationWithFactoryMethod(): void
    {
        // when
        $penId = PenId::create();

        //then
        $this->assertInstanceOf(PenId::class, $penId);
    }

    public function testIdentificationValue(): void
    {
        // when
        $penId = PenId::create();

        //then
        $this->assertIsString($penId->value());
    }

    public function testIdentificationToCastToString(): void
    {
        // when
        $penId = PenId::create();

        //then
        $this->assertIsString((string)$penId);
    }

    public function testIdentificationEquality(): void
    {
        // given
        $penId1 = PenId::create();
        $penId2 = PenId::create();

        //when
        $isEqual = $penId1->equalsTo($penId2);

        //then
        $this->assertFalse($isEqual);
    }
}
