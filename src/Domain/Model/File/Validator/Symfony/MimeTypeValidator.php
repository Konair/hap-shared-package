<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator\Symfony;

use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class MimeTypeValidator extends ConstraintValidator
{
    private MimeTypes $mimeTypes;

    public function __construct()
    {
        $this->mimeTypes = new MimeTypes();
    }

    /**
     * todo: resolve the following warnings
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MimeType) {
            throw new UnexpectedTypeException($constraint, MimeType::class);
        }

        if (is_null($value) || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (count($this->mimeTypes->getExtensions($value)) === 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        [$discreteType] = explode('/', $value);

        if ($constraint->allowedDiscreteTypes !== null && !in_array($discreteType, $constraint->allowedDiscreteTypes)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        if ($constraint->allowedMimeTypes !== null && !in_array($value, $constraint->allowedMimeTypes)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
