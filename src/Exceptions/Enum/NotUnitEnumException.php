<?php

declare(strict_types=1);

namespace Spark\Exceptions\Enum;

use Spark\Exceptions\Enum\InvalidEnumException;

/**
 * Not Unit Enum Exception
 *
 * @package Spark\Exceptions\Enum
 */
class NotUnitEnumException extends InvalidEnumException
{
    /**
     * Class name is not enum
     *
     * @var string
     */
    protected string $className;

    /**
     * Constructor
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;

        parent::__construct("Class {$className} is not enum. This trait can only be used with UnitEnum.");
    }

    /**
     * Get class name
     *
     * @return string
     */
    public function className(): string
    {
        return $this->className;
    }
}
