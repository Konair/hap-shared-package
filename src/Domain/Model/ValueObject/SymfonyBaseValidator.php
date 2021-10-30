<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\ValueObject;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class SymfonyBaseValidator implements Validator
{
    protected ValidatorInterface $validator;
    /** @var ConstraintViolationListInterface<ConstraintViolationInterface> */
    protected ConstraintViolationListInterface $violations;

    final public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    abstract public function validate(mixed $value): void;

    final public function isValid(): bool
    {
        return is_countable($this->violations) && count($this->violations) === 0;
    }

    /** @return string[] */
    final public function getErrorMessages(): array
    {
        $errors = [];

        if (count($this->violations) !== 0) {
            foreach ($this->violations as $violation) {
                $errors[] = (string)$violation->getMessage();
            }
        }

        return $errors;
    }
}
