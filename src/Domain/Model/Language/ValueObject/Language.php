<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Language\ValueObject;

use JsonSerializable;
use Stringable;
use Konair\HAP\Shared\Domain\Model\ValueObject\ValueObject;

final class Language implements ValueObject, Stringable, JsonSerializable
{
    /**
     * @SuppressWarnings(PHPMD.ShortMethodName)
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public static function HU(): self
    {
        return new self('Hungarian', 'hu', 'hun');
    }

    /**
     * @SuppressWarnings(PHPMD.ShortMethodName)
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public static function DE(): self
    {
        return new self('German', 'de', 'ger');
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCasePropertyName)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function __construct(
        private string $ISOLanguageName,
        private string $twoLetterISOCode,
        private string $threeLetterISOCode,
    ) {
        $this->ISOLanguageName = ucfirst($ISOLanguageName);
        $this->twoLetterISOCode = strtolower($twoLetterISOCode);
        $this->threeLetterISOCode = strtolower($threeLetterISOCode);
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function ISOLanguageName(): string
    {
        return $this->ISOLanguageName;
    }

    public function twoLetterISOCode(): string
    {
        return $this->twoLetterISOCode;
    }

    public function threeLetterISOCode(): string
    {
        return $this->threeLetterISOCode;
    }

    public function equalsTo(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $valueObject->ISOLanguageName() === $this->ISOLanguageName()
            && $valueObject->twoLetterISOCode() === $this->twoLetterISOCode()
            && $valueObject->threeLetterISOCode() === $this->threeLetterISOCode();
    }

    public function jsonSerialize(): string
    {
        return (string)json_encode([
            'ISOLanguageName' => $this->ISOLanguageName,
            'twoLetterISOCode' => $this->twoLetterISOCode,
            'threeLetterISOCode' => $this->threeLetterISOCode,
        ]);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
