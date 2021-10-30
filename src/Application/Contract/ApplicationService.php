<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Contract;

/**
 * @template T of Request
 */
interface ApplicationService
{
    /**
     * @param  T $request
     * @return Response
     */
    public function execute(Request $request): Response;
}
