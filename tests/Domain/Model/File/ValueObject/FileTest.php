<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    private const MIME_TYPE_VALUE = 'image/png';
    private const SIZE_VALUE = 1024;
    private const PATH = '/my/custom/path/hash';
    private const ORIGINAL_FILE_NAME = 'file.png';

    public function testFactoryMethod(): void
    {
        // given
        $mimeType = MimeType::create(self::MIME_TYPE_VALUE);
        $size = FileSize::create(self::SIZE_VALUE);
        $path = FilePath::create(self::PATH);
        $originalFileName = FileName::create(self::ORIGINAL_FILE_NAME);

        // when
        $file = DummyFile::create($mimeType, $path, $originalFileName, $size);

        // then
        $this->assertInstanceOf(DummyFile::class, $file);
    }

    public function testEqualityOfFiles(): void
    {
        // given
        $mimeType = MimeType::create(self::MIME_TYPE_VALUE);
        $size = FileSize::create(self::SIZE_VALUE);
        $path = FilePath::create(self::PATH);
        $originalFileName = FileName::create(self::ORIGINAL_FILE_NAME);
        $file1 = DummyFile::create($mimeType, $path, $originalFileName, $size);
        $file2 = DummyFile::create($mimeType, $path, $originalFileName, $size);

        // when
        $isEquals = $file1->equalsTo($file2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testInequalityOfFiles(): void
    {
        // given
        $mimeType = MimeType::create(self::MIME_TYPE_VALUE);
        $size = FileSize::create(self::SIZE_VALUE);
        $path = FilePath::create(self::PATH);
        $originalFileName = FileName::create(self::ORIGINAL_FILE_NAME);
        $file1 = DummyFile::create($mimeType, $path, $originalFileName, $size);
        $file2 = DummyFile::create($mimeType, $path, $originalFileName, FileSize::create(1000));

        // when
        $isEquals = $file1->equalsTo($file2);

        // then
        $this->assertFalse($isEquals);
    }

    public function testFileToCastToString(): void
    {
        // given
        $mimeType = MimeType::create(self::MIME_TYPE_VALUE);
        $size = FileSize::create(self::SIZE_VALUE);
        $path = FilePath::create(self::PATH);
        $originalFileName = FileName::create(self::ORIGINAL_FILE_NAME);
        $file = DummyFile::create($mimeType, $path, $originalFileName, $size);

        // when
        $fileValue = (string)$file;

        // then
        $this->assertIsString($fileValue);
    }
}
