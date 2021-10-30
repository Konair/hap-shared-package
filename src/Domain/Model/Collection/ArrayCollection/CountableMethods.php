<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Collection\ArrayCollection;

trait CountableMethods
{
    public function count(): int
    {
        return count($this->elements);
    }
}
