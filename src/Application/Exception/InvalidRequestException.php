<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Application\Exception;

use Konair\HAP\Shared\Domain\Model\ValueObject\Exception\ValidationException;

final class InvalidRequestException extends ApplicationException
{
    /** @var string[] */
    private array $messages;

    public static function fromValidationException(ValidationException $exception): self
    {
        return new self($exception->messages());
    }

    /**
     * @param string[] $messages
     * @return self
     */
    public static function withMessages(array $messages): self
    {
        return new self($messages);
    }

    /** @param string[] $messages */
    public function __construct(array $messages = null)
    {
        $this->messages = is_null($messages) ? [] : $messages;
    }

    /** @return string[] */
    public function messages(): array
    {
        return $this->messages;
    }
}
