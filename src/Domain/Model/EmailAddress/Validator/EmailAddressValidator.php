<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\EmailAddress\Validator;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Konair\HAP\Shared\Domain\Model\ValueObject\SymfonyBaseValidator;

final class EmailAddressValidator extends SymfonyBaseValidator
{
    public function validate(mixed $value): void
    {
        $this->violations = $this->validator->validate($value, [
            new Type(['type' => 'string']),
            new Email(),
            new NotBlank()
        ]);
    }
}
