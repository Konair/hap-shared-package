<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;

final class ResolutionValidator extends SymfonyBaseValidator
{
    public function validate(mixed $value): void
    {
        $width = $value['width'] ?? null;
        $height = $value['height'] ?? null;

        $this->violations = $this->validator->validate(
            $width,
            [
                new Type(['type' => 'integer']),
                new Positive(),
                new NotBlank(),
            ]
        );

        $this->violations->addAll($this->validator->validate(
            $height,
            [
                new Type(['type' => 'integer']),
                new Positive(),
                new NotBlank(),
            ]
        ));
    }
}
