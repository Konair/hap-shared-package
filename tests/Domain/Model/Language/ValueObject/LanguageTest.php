<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Language\ValueObject;

use PHPUnit\Framework\TestCase;

final class LanguageTest extends TestCase
{
    public function testHungarianLanguage(): void
    {
        // given
        // when
        $language = Language::HU();

        // then
        $this->assertSame('Hungarian', $language->ISOLanguageName());
        $this->assertSame('hu', $language->twoLetterISOCode());
        $this->assertSame('hun', $language->threeLetterISOCode());
    }

    public function testGermanLanguage(): void
    {
        // given
        // when
        $language = Language::DE();

        // then
        $this->assertSame('German', $language->ISOLanguageName());
        $this->assertSame('de', $language->twoLetterISOCode());
        $this->assertSame('ger', $language->threeLetterISOCode());
    }

    public function testLanguageEquality(): void
    {
        // given
        $hungarianLanguage1 = Language::HU();
        $hungarianLanguage2 = Language::HU();

        // when
        $isEquals = $hungarianLanguage1->equalsTo($hungarianLanguage2);

        // then
        $this->assertTrue($isEquals);
    }

    public function testLanguageInequality(): void
    {
        // given
        $hungarianLanguage = Language::HU();
        $germanLanguage = Language::DE();

        // when
        $isEquals = $hungarianLanguage->equalsTo($germanLanguage);

        // then
        $this->assertFalse($isEquals);
    }

    public function testLanguageToCastToString(): void
    {
        // given
        $language = Language::HU();

        // when
        $languageValue = (string)$language;

        // then
        $this->assertIsString($languageValue);
    }
}
