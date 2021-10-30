<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\ValueObject;

trait FileTrait
{
    protected MimeType $mimeType;
    protected FilePath $path;
    protected FileName $originalFilename;
    protected FileSize $size;

    public function mimeType(): MimeType
    {
        return $this->mimeType;
    }

    public function path(): FilePath
    {
        return $this->path;
    }

    public function originalFilename(): FileName
    {
        return $this->originalFilename;
    }

    public function fileSize(): FileSize
    {
        return $this->size;
    }
}
