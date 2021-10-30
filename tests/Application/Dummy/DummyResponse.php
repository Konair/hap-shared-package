<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Dummy;

use Konair\HAP\Shared\Application\Contract\Response;

final class DummyResponse implements Response
{
    private string|null $dummyText;

    public function __construct(string|null $dummyText)
    {
        $this->dummyText = $dummyText;
    }

    public function dummyText(): string|null
    {
        return $this->dummyText;
    }
}
