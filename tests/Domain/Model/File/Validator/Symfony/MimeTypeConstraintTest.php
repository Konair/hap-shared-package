<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator\Symfony;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MimeTypeConstraintTest extends TestCase
{
    private const MP4_TYPE = 'video/mp4';
    private const PNG_TYPE = 'image/png';
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
        parent::setUp();
    }

    public function testMimeType(): void
    {
        // given
        $value = self::PNG_TYPE;
        $constraint = new MimeType();

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(0, $violations);
    }

    public function testAllowedMimeType(): void
    {
        // given
        $value = self::PNG_TYPE;
        $constraint = new MimeType(['allowedDiscreteTypes' => ['image']]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(0, $violations);
    }

    public function testDeniedMimeType(): void
    {
        // given
        $value = self::MP4_TYPE;
        $constraint = new MimeType(['allowedDiscreteTypes' => ['image']]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(1, $violations);
    }

    public function testWithWrongDiscreteMimeType(): void
    {
        // given
        $value = self::MP4_TYPE;
        $constraint = new MimeType(['allowedDiscreteTypes' => ['wrong']]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(1, $violations);
    }

    public function testToAllowMimeType(): void
    {
        // given
        $value = self::PNG_TYPE;
        $constraint = new MimeType(['allowedMimeTypes' => [self::PNG_TYPE]]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(0, $violations);
    }

    public function testToAllowWrongMimeType(): void
    {
        // given
        $value = self::MP4_TYPE;
        $constraint = new MimeType(['allowedMimeTypes' => [self::PNG_TYPE]]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(1, $violations);
    }

    public function testToAllowInvalidMimeType(): void
    {
        // given
        $value = self::MP4_TYPE;
        $constraint = new MimeType(['allowedMimeTypes' => ['wrong']]);

        // when
        $violations = $this->validator->validate($value, [$constraint]);

        // then
        $this->assertCount(1, $violations);
    }
}
