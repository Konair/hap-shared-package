<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use Konair\HAP\Shared\Domain\Model\File\Validator\VideoValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;

final class DummyVideo extends Video
{
    public static function create(
        MimeType $mimeType,
        FilePath $path,
        FileName $originalFilename,
        Resolution $resolution,
        FileSize $size,
        Validator|null $validator = null,
    ): self {
        return new self($mimeType, $path, $originalFilename, $resolution, $size, $validator ?: new VideoValidator());
    }
}
