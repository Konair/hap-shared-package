<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

abstract class Video implements ValueObject, Stringable, JsonSerializable
{
    use FileTrait;

    protected MimeType $mimeType;
    protected FilePath $path;
    protected FileName $originalFilename;
    protected Resolution $resolution;
    protected FileSize $size;
    protected Validator $validator;

    public function __construct(
        MimeType $mimeType,
        FilePath $path,
        FileName $originalFilename,
        Resolution $resolution,
        FileSize $size,
        Validator $validator,
    ) {
        $validator->validate([
            'mimeType' => $mimeType,
            'path' => $path,
            'originalFilename' => $originalFilename,
            'resolution' => $resolution,
            'size' => $size,
        ]);

        if (!$validator->isValid()) {
            throw ValidationException::withMessages($validator->getErrorMessages());
        }

        $this->mimeType = $mimeType;
        $this->path = $path;
        $this->originalFilename = $originalFilename;
        $this->resolution = $resolution;
        $this->size = $size;
    }

    public function resolution(): Resolution
    {
        return $this->resolution;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->mimeType()->equalsTo($this->mimeType())
            && $valueObject->path()->equalsTo($this->path())
            && $valueObject->originalFilename()->equalsTo($this->originalFilename())
            && $valueObject->fileSize()->equalsTo($this->fileSize())
            && $valueObject->resolution()->equalsTo($this->resolution());
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'mimeType' => $this->mimeType->value(),
            'path' => $this->path->value(),
            'originalFilename' => $this->originalFilename->value(),
            'resolution' => json_decode($this->resolution->jsonSerialize(), true),
            'size' => $this->size->value(),
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
