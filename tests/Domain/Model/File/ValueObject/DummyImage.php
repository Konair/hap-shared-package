<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Konair\HAP\Shared\Domain\Model\File\Validator\ImageValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;

final class DummyImage extends Image
{
    public static function create(
        MimeType $mimeType,
        FilePath $path,
        FileName $originalFilename,
        Resolution $resolution,
        FileSize $size,
        Validator|null $validator = null,
    ): self {
        return new self($mimeType, $path, $originalFilename, $resolution, $size, $validator ?: new ImageValidator());
    }
}
