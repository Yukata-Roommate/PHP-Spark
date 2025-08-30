<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Validation Exception
 *
 * @package Spark\Exceptions\Console
 */
class ValidationException extends ArgumentException
{
    /**
     * Validation errors
     *
     * @var array<string, string>
     */
    protected array $errors;

    /**
     * Constructor
     *
     * @param string $message
     * @param array<string, string> $errors
     */
    public function __construct(string $message, array $errors)
    {
        $this->errors = $errors;

        parent::__construct($message);
    }

    /**
     * Get validation errors
     *
     * @return array<string, string>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Check if has errors
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
