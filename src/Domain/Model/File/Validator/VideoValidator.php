<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator;

use Symfony\Component\Validator\Constraints\NotBlank;
use Konair\HAP\Shared\Domain\Model\File\Validator\Symfony\MimeType;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;

final class VideoValidator extends SymfonyBaseValidator
{
    public function validate(mixed $value): void
    {
        $mimeType = $value['mimeType'] ?? null;

        $this->violations = $this->validator->validate(
            $mimeType?->value(),
            [
                new MimeType(['allowedDiscreteTypes' => ['video']]),
                new NotBlank(),
            ]
        );
    }
}
