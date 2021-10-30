<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\File\Validator\Symfony;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
final class MimeType extends Constraint
{
    public string $message = 'The string "{{ string }}" ...';

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $options
     * @param string[]|null $allowedDiscreteTypes One or multiple discrete types to validate against or a set of
     *                                            options.
     * @param string[]|null $allowedMimeTypes One or multiple mime types to validate against or a set of options.
     */
    public function __construct(
        array $options = [],
        public array|null $allowedDiscreteTypes = null,
        public array|null $allowedMimeTypes = null,
        array $groups = null,
        $payload = null,
    ) {
        $this->allowedDiscreteTypes = $options['allowedDiscreteTypes'] ?? $allowedDiscreteTypes;
        $this->allowedMimeTypes = $options['allowedMimeTypes'] ?? $allowedMimeTypes;

        parent::__construct($options, $groups, $payload);
    }
}
