<?php

declare(strict_types=1);

namespace Spark\Exceptions\Container;

use Spark\Exceptions\Container\EnumException;

/**
 * Invalid Enum Value Exception
 *
 * @package Spark\Exceptions\Container
 */
class InvalidEnumValueException extends EnumException
{
    /**
     * Enum class name
     *
     * @var string
     */
    protected string $enumClass;

    /**
     * Property name
     *
     * @var string
     */
    protected string $propertyName;

    /**
     * Constructor
     *
     * @param string $enumClass
     * @param string $propertyName
     */
    public function __construct(string $enumClass, string $propertyName)
    {
        $this->enumClass    = $enumClass;
        $this->propertyName = $propertyName;

        parent::__construct("Invalid enum value for property \"{$propertyName}\". Value is not valid case of {$enumClass}");
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
