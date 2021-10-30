<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Dummy;

use Konair\HAP\Shared\Application\Contract\ApplicationService;
use Konair\HAP\Shared\Application\Contract\Request;
use Konair\HAP\Shared\Application\Exception\InvalidRequestException;

/**
 * @implements ApplicationService<DummyRequest>
 */
final class DummyService implements ApplicationService
{
    /**
     * @throws InvalidRequestException
     */
    public function execute(Request $request): DummyResponse
    {
        if (!$request instanceof DummyRequest) {
            throw new InvalidRequestException();
        }

        return new DummyResponse($request->dummyText());
    }
}
