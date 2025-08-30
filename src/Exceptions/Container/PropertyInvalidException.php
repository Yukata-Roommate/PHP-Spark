<?php

declare(strict_types=1);

namespace Spark\Exceptions\Container;

use Spark\Exceptions\Container\ValidationException;

/**
 * Property Invalid Exception
 *
 * @package Spark\Exceptions\Container
 */
class PropertyInvalidException extends ValidationException
{
    /**
     * Property name failed validation
     *
     * @var string
     */
    protected string $propertyName;

    /**
     * Constructor
     *
     * @param string $propertyName
     */
    public function __construct(string $propertyName)
    {
        $this->propertyName = $propertyName;

        parent::__construct("Validation failed for property \"{$propertyName}\"");
    }

    /**
     * Get property name
     *
     * @return string
     */
    public function propertyName(): string
    {
        return $this->propertyName;
    }
}
