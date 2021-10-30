<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Address\Validator;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;
use Konair\HAP\Shared\Domain\Model\ValueObject\Validator;

final class LineValidator extends SymfonyBaseValidator implements Validator
{
    public function validate(mixed $value): void
    {
        $this->violations = $this->validator->validate($value, [
            new Type(['type' => 'string']),
            new NotBlank()
        ]);
    }
}
