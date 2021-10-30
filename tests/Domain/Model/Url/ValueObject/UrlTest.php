<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Url\ValueObject;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class UrlTest extends TestCase
{
    public function testUrlToCreate(): void
    {
        // when
        $url = Url::create('http://domain.tld');

        // then
        $this->assertInstanceOf(Url::class, $url);
    }

    public function testUrlEquality(): void
    {
        // given
        $url1 = Url::create('http://domain.tld');
        $url2 = Url::create('http://domain.tld');

        // when
        $isEqual = $url1->equalsTo($url2);

        // then
        $this->assertTrue($isEqual);
    }

    public function testUrlToCastToString(): void
    {
        // given
        $url = Url::create('http://domain.tld');

        // when
        $urlValue = (string)$url;

        // then
        $this->assertIsString($urlValue);
    }

    public function testInvalidUrl(): void
    {
        // then
        $this->expectException(ValidationException::class);

        // given
        Url::create('something');
    }
}
