<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class VideoTest extends TestCase
{
    private const IMAGE_MIME_TYPE_VALUE = 'image/png';
    private const VIDEO_MIME_TYPE_VALUE = 'video/mp4';
    private const SIZE_VALUE = 1024;
    private const PATH = '/my/custom/path/hash';
    private const ORIGINAL_FILE_NAME = 'file.png';

    public function testVideoToCreate(): void
    {
        //given
        $mimeType = MimeType::create(self::VIDEO_MIME_TYPE_VALUE);
        $filePath = FilePath::create(self::PATH);
        $fileName = FileName::create(self::ORIGINAL_FILE_NAME);
        $resolution = Resolution::create(100, 100);
        $fileSize = FileSize::create(self::SIZE_VALUE);

        // when
        $image = DummyVideo::create(
            $mimeType,
            $filePath,
            $fileName,
            $resolution,
            $fileSize,
        );

        // then
        $this->assertInstanceOf(DummyVideo::class, $image);
    }

    public function testVideoToCreateWithVideo(): void
    {
        // then
        $this->expectException(ValidationException::class);

        //given
        $mimeType = MimeType::create(self::IMAGE_MIME_TYPE_VALUE);
        $filePath = FilePath::create(self::PATH);
        $fileName = FileName::create(self::ORIGINAL_FILE_NAME);
        $resolution = Resolution::create(100, 100);
        $fileSize = FileSize::create(self::SIZE_VALUE);

        // when
        DummyVideo::create(
            $mimeType,
            $filePath,
            $fileName,
            $resolution,
            $fileSize,
        );
    }
}
