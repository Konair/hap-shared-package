<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Url\Validator;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;

final class UrlValidator extends SymfonyBaseValidator
{
    public function validate(mixed $value): void
    {
        $this->violations = $this->validator->validate($value, [
            new Type(['type' => 'string']),
            new Url(),
            new NotBlank()
        ]);
    }
}
