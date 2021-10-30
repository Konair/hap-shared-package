<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

final class DummyFile extends File
{
    public static function create(
        MimeType $mimeType,
        FilePath $path,
        FileName $originalFilename,
        FileSize $size,
    ): self {
        return new self($mimeType, $path, $originalFilename, $size);
    }
}
