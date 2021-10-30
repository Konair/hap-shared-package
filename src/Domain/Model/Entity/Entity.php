<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Entity;

use Konair\HAP\Shared\Domain\Model\Identification\Identification;

/**
 * @template T of Identification;
 */
interface Entity
{
    /** @return T */
    public function identification(): Identification;
}
