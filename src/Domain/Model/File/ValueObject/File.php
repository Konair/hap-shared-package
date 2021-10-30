<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

abstract class File implements ValueObject, Stringable, JsonSerializable
{
    use FileTrait;

    public function __construct(
        protected MimeType $mimeType,
        protected FilePath $path,
        protected FileName $originalFilename,
        protected FileSize $size,
    ) {
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->mimeType()->equalsTo($this->mimeType())
            && $valueObject->path() === $this->path()
            && $valueObject->originalFilename() === $this->originalFilename()
            && $valueObject->fileSize()->equalsTo($this->fileSize());
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'mimeType' => $this->mimeType->value(),
            'path' => $this->path->value(),
            'originalFilename' => $this->originalFilename->value(),
            'size' => $this->size->value(),
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
