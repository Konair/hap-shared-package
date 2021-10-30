<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Contract;

use Exception;
use Konair\HAP\Shared\Application\Exception\InvalidRequestException;
use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Application\Dummy\DummyRequest;
use Konair\HAP\Shared\Application\Dummy\DummyResponse;
use Konair\HAP\Shared\Application\Dummy\DummyService;

final class ApplicationServiceTest extends TestCase
{
    /** @throws Exception */
    public function testApplicationServiceContract(): void
    {
        // given
        $request = new DummyRequest('text');
        $service = new DummyService();

        // when
        $response = $service->execute($request);

        // then
        $this->assertInstanceOf(DummyResponse::class, $response);
    }

    /** @throws Exception */
    public function testTo(): void
    {
        // then
        $this->expectException(InvalidRequestException::class);

        // given
        /** @var DummyRequest $request */
        $request = $this->createMock(Request::class);
        $service = new DummyService();

        // when
        $service->execute($request);
    }
}
