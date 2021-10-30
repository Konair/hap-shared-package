<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Type;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;

final class FileSizeValidator extends SymfonyBaseValidator
{
    public function validate(mixed $value): void
    {
        $this->violations = $this->validator->validate($value, [
            new Type(['type' => 'integer']),
            new PositiveOrZero(),
            new NotBlank(),
        ]);
    }
}
