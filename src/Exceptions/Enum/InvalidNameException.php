<?php

declare(strict_types=1);

namespace Spark\Exceptions\Enum;

use Spark\Exceptions\Enum\ValueException;

/**
 * Invalid Name Exception
 *
 * @package Spark\Exceptions\Enum
 */
class InvalidNameException extends ValueException
{
    /**
     * Enum class name
     *
     * @var string
     */
    protected string $className;

    /**
     * Invalid enum name
     *
     * @var int|string
     */
    protected int|string $name;

    /**
     * Constructor
     *
     * @param string $className
     * @param int|string $name
     */
    public function __construct(string $className, int|string $name)
    {
        $this->className = $className;
        $this->name      = $name;

        parent::__construct("\"{$name}\" is not valid name in enum {$className}.");
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

    /**
     * Get invalid name
     *
     * @return int|string
     */
    public function name(): int|string
    {
        return $this->name;
    }
}
