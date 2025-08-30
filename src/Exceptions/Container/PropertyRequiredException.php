<?php

declare(strict_types=1);

namespace Spark\Exceptions\Container;

use Spark\Exceptions\Container\ValidationException;

/**
 * Property Required Exception
 *
 * @package Spark\Exceptions\Container
 */
class PropertyRequiredException extends ValidationException
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

        parent::__construct("Property \"{$propertyName}\" is required.");
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
