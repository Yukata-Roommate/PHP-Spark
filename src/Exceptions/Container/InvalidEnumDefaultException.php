<?php

declare(strict_types=1);

namespace Spark\Exceptions\Container;

use Spark\Exceptions\Container\EnumException;

/**
 * Invalid Enum Default Exception
 *
 * @package Spark\Exceptions\Container
 */
class InvalidEnumDefaultException extends EnumException
{
    /**
     * Enum class name
     *
     * @var string
     */
    protected string $enumClass;

    /**
     * Constructor
     *
     * @param string $enumClass
     */
    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;

        parent::__construct("Default value must be instance of {$enumClass}.");
    }

    /**
     * Get enum class name
     *
     * @return string
     */
    public function enumClass(): string
    {
        return $this->enumClass;
    }
}
