<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Exception;

use Exception;

abstract class ApplicationException extends Exception
{
    public function referenceName(): string
    {
        $className = explode('\\', static::class);
        end($className);

        return str_replace('Exception', '', current($className));
    }

    public function referenceId(): string
    {
        return sha1(static::class);
    }
}
